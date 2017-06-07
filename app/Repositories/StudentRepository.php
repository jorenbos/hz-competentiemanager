<?php

namespace App\Repositories;

use App\Models\Competency;
use App\Models\Student;
use App\Util\Constants;
use Illuminate\Database\Eloquent\Collection;
use Rinvex\Repository\Repositories\EloquentRepository;

class StudentRepository extends EloquentRepository implements StudentRepositoryContract
{
    protected $repositoryId = 'hz.students';
    protected $model = Student::class;
    protected $relations = ['competencies'];

     /**
      * @var CompetencyRepository
      */
     private $competencyRepository;

      /**
       * @var SlotRepository
       */
      private $slotRepository;

      /**
       * @var TimetableRepository
       */
      private $timetableRepository;

    public function __construct(CompetencyRepository $competencyRepository, SlotRepository $slotRepository, TimetableRepository $timetableRepository)
    {
        $this->competencyRepository = $competencyRepository;
        $this->slotRepository = $slotRepository;
        $this->timetableRepository = $timetableRepository;
    }

    /**
     * @return Student[]|Collection not on minor or internship
     */
    public function getStudentsForAlgorithm($timetable)
    {
        //Currently hard coded to exlude internship/minor
        $competenciesThatExludeStudentsFromAlgorithm = collect([17, 18, 19, 20, 27]);

        return $this->findAll()->filter(function ($student) use ($competenciesThatExludeStudentsFromAlgorithm, $timetable) {
            foreach ($student->competencies as $competency) {
                if (($competenciesThatExludeStudentsFromAlgorithm->contains($competency->id)
                    && $competency->pivot->timetable === $timetable->id)
                    || ($competency->id === 27
                    && $competency->pivot->timetable != null
                    && $this->timetableRepository->getById($competency->pivot->timetable)->starting_date <= $timetable->starting_date)) {
                    return false;
                }
            }

            return true;
        });
    }

    /**
     * @param $id
     *
     * @return Competency[]
     */
    public function getUncompletedCompetencies($student)
    {
        if ($student == null) {
            return collect();
        }
        $statusByCompetency = $student->competencies;

        return $this->competencyRepository->findAllowedForAlgorithm()->filter(function ($competency) use ($statusByCompetency) {
            $statusCompetency = $statusByCompetency->where('id', $competency->id)->first();
            if ($statusCompetency == null) {
                return true;
            } else {
                return $statusCompetency->pivot->status !== Competency::STATUS_DONE;
            }
        });
    }

    /**
     * @param Competency[]|Collection $competencies
     *
     * @return Competency[]|Collection
     */
    public function filterSequentiality($competencies)
    {
        return $competencies->filter(function($competency) {
            $comboCount = 0;
            $comboReq = 0;
            $allowed = true;
            $competency->each(function($seqComp) {
                $rule = $seqComp->pivot->rule;
                $isInComps = $competencies->contains('id', $seqComp->id);
                if ($rule === Constants::RULE_TYPE_SEQUENTIAL_REQUIRED && $isInComps) {
                    $isAllowed = false;
                    return false; // equivalent to break
                } elseif ($rule === Constants::RULE_TYPE_SEQUENTIAL_COMBO) {
                    $comboReq = ($comboReq === 0) ? $seqComp->pivot->amount_required : $comboReq;
                    if ($isInComps) $comboCount++;
                }
            });
            $allowed = ($comboCount < $comboReq) ? false : $allowed;
            return $allowed;
        });
    }

    /**
     * @param Student           $student
     * @param Slot[]|Collection $toDoSlots
     *
     * @return int
     */
    public function getToDoCredits($student, $toDoSlots)
    {
        $toDoCredits = 0;

        foreach ($toDoSlots as $slot) {
            $toDoCredits += $slot->competencies->first()->ec_value;
        }

        return $toDoCredits;
    }

    /**
     * @param $id of Student
     *
     * @return Slot[] left to do by Student
     */
    public function getToDoSlots($student, $timetable)
    {
        $doneSlots = collect();
        $toDoSlots = collect();

        //Collect slots depending on student phase
        $studentMainPhaseDate = new \DateTime($student->starting_date);
        $studentMainPhaseDate->modify('+1 year');
        if ($studentMainPhaseDate <= new \DateTime($timetable->starting_date)) {
            $toDoSlots = $this->slotRepository->findAll();
        } else {
            $toDoSlots = $this->slotRepository->findAllPropedeuseSlots();
        }
        $selectableToDoSlots = $toDoSlots;
        //TODO: Add rule 3: Minimum EC value
        //Create array with slotId's of competencies with status done or doing
        foreach ($student->competencies as $studentCompetency) {
            if ($studentCompetency->pivot->status === Competency::STATUS_DOING ||
                $studentCompetency->pivot->status === Competency::STATUS_DONE
            ) {
                $bestSlot = $this->determineBestSlotChoice($studentCompetency, $selectableToDoSlots);
                $doneSlots->push($bestSlot);

                //Remove selected slot from list of selectable slots
                $selectableToDoSlotsFiltered = $selectableToDoSlots->reject(function ($value, $key) use ($bestSlot) {
                    return $value->id === $bestSlot->id;
                });
                $selectableToDoSlots = $selectableToDoSlotsFiltered;
            }
        }

        //Filter toDoSlots so that all done slots are removed
        foreach ($doneSlots as $doneSlot) {
            $filteredToDoSlots = $toDoSlots->reject(function ($value, $key) use ($doneSlot) {
                return $value->id === $doneSlot->id;
            });
            $toDoSlots = $filteredToDoSlots;
        }

        $toDoSlots = $this->filterToDoSlots($toDoSlots, $student);

        return $toDoSlots;
    }

    private function filterToDoSlots($toDoSlots, $student)
    {
        $toDoSlots = $toDoSlots->keyBy('id');
        $uncompletedCompetencies = $this->getUncompletedCompetencies($student);
        $viableCompetencies = $this->filterSequentiality($uncompletedCompetencies)->keyBy('id');

        //Removes completed and not allowed(sequentiality) competencies
        $toDoSlots = $toDoSlots->map(function ($slot, $key) use ($viableCompetencies) {
            $competenciesToBeRemoved = $slot->competencies->filter(function ($competency, $key) use ($viableCompetencies) {
                return !$viableCompetencies->contains('id', $competency->id);
            });

            for ($i = 0; $i < count($competenciesToBeRemoved); $i++) {
                unset($slot->competencies[$slot->competencies->search($competenciesToBeRemoved->values()[$i])]);
            }

            return $slot;
        });

        //Removes slots with no possible competencies
        $filteredToDoSlots = $toDoSlots->reject(function ($slot, $key) {
            return $slot->competencies->isEmpty();
        });

        return $filteredToDoSlots;
    }

    private function determineBestSlotChoice($studentCompetency, $selectableToDoSlots)
    {
        //Determine in which slots the competency is able to be done
        $possibleInSlots = $selectableToDoSlots->filter(function ($value, $key) use ($studentCompetency) {
            $ret = $value->competencies;

            return $ret->contains('id', $studentCompetency->id);
        });

        //Order possible slots by amount of possible competencies in slot
        $sortedPossibleInSlots = $possibleInSlots->sortBy(function ($value, $key) {
            return count($value->competencies);
        });

        return $sortedPossibleInSlots->first();
    }
}
