<?php

namespace App\Repositories;

use App\Models\Competency;
use App\Models\Student;
use App\Util\Constants;
use App\Util\RepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class StudentRepository implements RepositoryInterface
{
    /**
      * @var Student
      */
     private $students;

      /**
       * @var SlotRepository
       */
      private $slotRepository;

      /**
       * @var TimetableRepository
       */
      private $timetableRepository;

    public function __construct(Student $students, SlotRepository $slotRepository, TimetableRepository $timetable)
    {
        $this->students = $students;
        $this->slotRepository = $slotRepository;
        $this->timetableRepository = $timetable;
    }

    /**
     * @param $id
     *
     * @return Student
     */
    public function getById($id)
    {
        return $this->students->findOrFail($id);
    }

//end getById()

    /**
     * @return Student[]|Collection
     */
    public function getAll()
    {
        return $this->students->all();
    }

//end getAll()

    /**
     * @param array $attributes
     *
     * @return mixed
     */
    public function create(array $attributes)
    {
        return $this->students->create($attributes);
    }

//end create()

    /**
     * @param int $ids
     *
     * @return mixed
     */
    public function delete($ids)
    {
        return $this->students->destroy($ids);
    }

//end delete()

    /**
     * @return Student[]|Collection not on minor or internship
     */
    public function getStudentsForAlgorithm()
    {
        //TODO Filtering moet nog toegepast worden
        return $this->students->all();
    }

//end getStudentsForAlgorithm()

    /**
     * @param $id
     *
     * @return Competency[]
     */
    public function getCompletedCompetencies($student)
    {
        if ($student != null) {
            $competencies = [];
            foreach ($student->competencies as $competency) {
                if ($competency->pivot->status == Constants::COMPETENCY_STATUS_DONE) {
                    $competencies[] = $competency;
                }
            }

            return $competencies;
        }

        return [];
    }

//end getCompletedCompetencies()

    /**
     * @param $id
     *
     * @return Competency[]
     */
    public function getUncompletedCompetencies($student)
    {
        $returnCompetencies = collect();
        if ($student != null) {
            $allCompetencies = Competency::all()->all();

            foreach ($allCompetencies as $competency) {
                $matching_comp = $student->competencies()->find($competency->id);
                if ($matching_comp != null) {
                    if ($matching_comp->pivot->status !== Constants::COMPETENCY_STATUS_DONE) {
                        $returnCompetencies->push($matching_comp);
                    }
                } else {
                    $returnCompetencies->push($competency);
                }
            }
        }

        return $returnCompetencies;
    }

    /**
     * @param Competency[]|Collection $competencies
     *
     * @return Competency[]|Collection
     */
    public function filterSequentiality($competencies)
    {
        $returnCompetencies = collect();
        foreach ($competencies as $competency) {
            $isAllowed = true;
            $ruleSequentialComboRequired = 0;
            $ruleSequentialComboCounter = 0;

            foreach ($competency->sequentiality as $sequentialCompetency) {
                if ($sequentialCompetency->pivot->rule === Constants::RULE_TYPE_SEQUENTIAL_REQUIRED
                    && $competencies->contains('id', $sequentialCompetency->id)
                ) {
                    $isAllowed = false;
                    break;
                } elseif ($sequentialCompetency->pivot->rule === Constants::RULE_TYPE_SEQUENTIAL_COMBO) {
                    if ($ruleSequentialComboRequired === 0) {
                        $ruleSequentialComboRequired = $sequentialCompetency->pivot->amount_required;
                    }
                    if (!$competencies->contains('id', $sequentialCompetency->id)) {
                        $ruleSequentialComboCounter++;
                        var_dump($ruleSequentialComboCounter);
                    }
                }
            }

            if ($ruleSequentialComboCounter < $ruleSequentialComboRequired) {
                $isAllowed = false;
            }

            if ($isAllowed) {
                $returnCompetencies->push($competency);
            }
        }

        return $returnCompetencies;
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
    public function getToDoSlots($student)
    {
        $doneSlots = collect();
        $toDoSlots = collect();

        //Collect slots depending on student phase
        $studentMainPhaseDate = new \DateTime($student->starting_date);
        $studentMainPhaseDate->modify('+1 year');
        if ($studentMainPhaseDate <= new \DateTime($this->timetableRepository->getNext()['starting_date'])) {
            $toDoSlots = $this->slotRepository->getAll();
        } else {
            $toDoSlots = $this->slotRepository->getAllPropedeuse();
        }
        $selectableToDoSlots = $toDoSlots;

        //Create array with slotId's of competencies with status done or doing
        foreach ($student->competencies as $studentCompetency) {
            if ($studentCompetency->pivot->status === Constants::COMPETENCY_STATUS_DOING ||
                $studentCompetency->pivot->status === Constants::COMPETENCY_STATUS_DONE
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
        $viableCompetencies = $this->filterSequentiality($this->getUncompletedCompetencies($student))->keyBy('id');

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
}//end class
