<?php
/**
 * Created by Roel van Endhoven.
 * User: Roel van Endhoven
 * Date: 12-1-17
 * Time: 11:11.
 */

namespace App\Repositories;

use App\Models\Competency;
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
        foreach ($this->getUncompletedCompetencies($id) as $competency) {
            $slotValue = 0;
            $matching_comp = $this->getById($id)->competencies()->find($competency->id);
            if ($matching_comp != null) {
                if ($matching_comp->pivot->status == Constants::COMPETENCY_STATUS_HALF_DOING
                    || $matching_comp->pivot->status == Constants::COMPETENCY_STATUS_HALF_DONE) {
                    $slotValue = 2.5;
                }
            } else {
                $slotValue = $competency->ec_value;
            }
            $toDoCredits += $slotValue;
        }

        return $toDoCredits;
    }
}//end class
