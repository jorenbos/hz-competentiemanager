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
        if ($student != null) {
            $allCompetencies = Competency::all()->all();
            $returnCompetencies = [];

            foreach ($allCompetencies as $competency) {
                $matching_comp = $student->competencies()->find($competency->id);
                if ($matching_comp != null) {
                    if ($matching_comp->pivot->status !== Constants::COMPETENCY_STATUS_DONE) {
                        $returnCompetencies[] = $matching_comp;
                    }
                } else {
                    $returnCompetencies[] = $competency;
                }
            }

            return $returnCompetencies;
        }

        return [];
    }

    //end getUncompletedCompetencies()

    /**
     * @param $id
     *
     * @return int
     */
    public function getToDoCredits($student, $toDoSlots)
    {
        $toDoCredits = 0;

        foreach ($toDoSlots as $slot) {
            $keysStudentSlotCompetencies = array_keys($slot->competencies->toArray());
            $toDoCredits += $slot->competencies[$keysStudentSlotCompetencies[0]]->ec_value;
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
        $doneSlots = [];
        $toDoSlots = [];

        //Collect slots depending on student phase
        $studentHoofdfaseDate = new \DateTime($student->starting_date);
        $studentHoofdfaseDate->modify('+1 year');
        if ($studentHoofdfaseDate <= $this->timetableRepository->getNext()['starting_date']) {
            $toDoSlots = $this->slotRepository->getAll();
        } else {
            $toDoSlots = $this->slotRepository->getAllPropedeuse();
        }

        //Create array with slotId's of competencies with status done or doing
        foreach ($student->competencies as $studentCompetency) {
            if ($studentCompetency->pivot->status === Constants::COMPETENCY_STATUS_DOING ||
                $studentCompetency->pivot->status === Constants::COMPETENCY_STATUS_DONE
            ) {
                array_push($doneSlots, array_search($studentCompetency->pivot->slot_id,
                           array_column($toDoSlots, 'id')));
            }
        }

        array_multisort($doneSlots, SORT_DESC);
        foreach ($doneSlots as $doneSlot) {
            unset($toDoSlots[$doneSlot]);
        }

        $toDoSlots = $this->filterToDoSlots($toDoSlots, $student);

        return $toDoSlots;
    }

    private function filterToDoSlots($toDoSlots, $student)
    {
        $keysToDoSlots = array_keys($toDoSlots);
        $completedCompetencies = $student->competencies;
        $keysCompletedCompetencies = array_keys($completedCompetencies->toArray());

        //Remove completed competencies from toDoSlots.
        for ($i = 0; $i < count($keysToDoSlots); $i++) {
            for ($j = 0; $j < count($keysCompletedCompetencies); $j++) {
                if ($toDoSlots[$keysToDoSlots[$i]]->competencies->contains($completedCompetencies[$keysCompletedCompetencies[$j]])) {
                    unset($toDoSlots[$keysToDoSlots[$i]]->competencies[$toDoSlots[$keysToDoSlots[$i]]->competencies->search($completedCompetencies[$keysCompletedCompetencies[$j]])]);
                }
            }
        }

        return $toDoSlots;
    }
}//end class
