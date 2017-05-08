<?php
/**
 * Created by Roel van Endhoven.
 * User: Roel van Endhoven
 * Date: 12-1-17
 * Time: 11:11.
 */

namespace App\Repositories;

use App\Models\Competency;
use App\Models\Slot;
use App\Models\Student;
use App\Util\Constants;
use App\Util\RepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class StudentRepository implements RepositoryInterface
{
    /**
     * @param $id
     *
     * @return Student
     */
    public function getById($id)
    {
        return Student::findOrFail($id);
    }

//end getById()

    /**
     * @return Student[]|Collection
     */
    public function getAll()
    {
        return Student::all();
    }

//end getAll()

    /**
     * @param array $attributes
     *
     * @return mixed
     */
    public function create(array $attributes)
    {
        return Student::create($attributes);
    }

//end create()

    /**
     * @param int $ids
     *
     * @return mixed
     */
    public function delete($ids)
    {
        return Student::destroy($ids);
    }

//end delete()

    /**
     * @return Student[]|Collection not on minor or internship
     */
    public function getStudentsForAlgorithm()
    {
        //TODO Filtering moet nog toegepast worden
        return Student::all();
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
        $toDoSlots = Slot::all()->all();
        $doneSlots = [];
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
