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
        return Student::All();
    }

//end getStudentsForAlgorithm()

    /**
     * @param $id
     *
     * @return Competency[]
     */
    public function getCompletedCompetencies($id)
    {
        $student = $this->getById($id);
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
    public function getUncompletedCompetencies($id)
    {
        $student = $this->getById($id);
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
    public function getToDoCredits($id)
    {
        $toDoCredits = 0;
        foreach ($this->getToDoSlots($id) as $slot) {

        }

        foreach ($this->getUncompletedCompetencies($id) as $competency) {
            $slotValue = 0;
            $matching_comp = $this->getById($id)->competencies()->find($competency->id);
            if ($matching_comp != null) {
                if ($matching_comp->pivot->status == Constants::COMPETENCY_STATUS_HALF_DOING ||
                    $matching_comp->pivot->status == Constants::COMPETENCY_STATUS_HALF_DONE) {
                    $slotValue = 2.5;
                }
            } else {
                $slotValue = $competency->ec_value;
            }
            $toDoCredits += $slotValue;
        }

        return $toDoCredits;
    }

    /**
     * @param $id of Student
     *
     * @return Slot[] left to do by Student
     */
    public function getToDoSlots($id)
    {
        $toDoSlots = Slot::all()->all();
        $doneSlots = [];
        foreach ($this->getById($id)->competencies as $studentCompetency) {
            if ($studentCompetency->pivot->status == Constants::COMPETENCY_STATUS_DOING ||
                $studentCompetency->pivot->status == Constants::COMPETENCY_STATUS_DONE) {
                array_push($doneSlots, array_search($studentCompetency->pivot->slot_id,
                           array_column($toDoSlots, 'id')));
                array_multisort($doneSlots, SORT_DESC);
            } else if ($studentCompetency->pivot->status == Constants::COMPETENCY_STATUS_HALF_DOING ||
                       $studentCompetency->pivot->status == Constants::COMPETENCY_STATUS_HALF_DONE) {
                foreach ($toDoSlots[array_search($studentCompetency->pivot->slot_id,
                         array_column($toDoSlots, 'id'))]->competencies as $key => $fillingCompetency) {
                    if ($fillingCompetency['attributes']['id'] != $studentCompetency['attributes']['id']) {
                        //Not working yet...
                        $toDoSlots[array_search($studentCompetency->pivot->slot_id, array_column($toDoSlots, 'id'))]['relations']['competencies'][$key] = $fillingCompetency;
                        // dd($test=[$fillingCompetency,$studentCompetency]);
                    }
                }
                dd($toDoSlots[array_search($studentCompetency->pivot->slot_id, array_column($toDoSlots, 'id'))]);
            }
        }
        foreach ($doneSlots as $doneSlot) {
            unset($toDoSlots[$doneSlot]);
        }

        return $toDoSlots;
    }
}//end class
