<?php

namespace App\Http\Controllers;

use App\Repositories\CompetencyRepository;
use App\Repositories\StudentRepository;

class DemandController extends Controller
{

    /**
     * @var StudentRepository
     */
    protected $students;

    /**
     * @var CompetencyRepository
     */
    protected $competencies;


    /**
     * Inject UserRepository and CompetencyRepository dependencies
     *
     * @param StudentRepository    $studentRepository
     * @param CompetencyRepository $competencyRepository
     */
    public function __construct(StudentRepository $studentRepository, CompetencyRepository $competencyRepository)
    {
        $this->setStudents($studentRepository);
        $this->setCompetencies($competencyRepository);

    }//end __construct()


    public function index()
    {
        return view('demand.index', ['competencies' => $this->calculate()]);

    }//end index()


    public function calculate()
    {
        $competencyCount = [];

        $students = $this->getStudents()->getAll();

        foreach ($students as $student) {
            foreach ($this->students->getUncompletedCompetencies($student->id) as $competency) {
                $competencyCount[$competency->id]['competency'] = $competency;
                if (!array_key_exists('count', $competencyCount[$competency->id])) {
                    $competencyCount[$competency->id]['count'] = 0;
                }

                if (!array_key_exists('mean_demand', $competencyCount[$competency->id])) {
                    $competencyCount[$competency->id]['mean_demand'] = 0;
                }

                $competencyCount[$competency->id]['count'] += 1;
                $competenciesPerStudentPerblock             = 2;
                $competenciesTodo = count($this->students->getUncompletedCompetencies($student->id));
                $competencyCount[$competency->id]['mean_demand'] += ($competenciesPerStudentPerblock / $competenciesTodo);
            }
        }

        return $competencyCount;

    }//end calculate()


    /*
        UNUSED CODE
        private function competency_demand_algorithm()
        {
        $calculated_competencies = [];

        foreach ($competencies as $competency) {
            $calculated_competencies[$competency->id] = 0;
        }

        foreach ($students as $student) {
            foreach ($student->todo_slots as $slot) {
                foreach ($slot->competencies as $competency) {
                    $calculated_competencies[$competency->id] += (1 / $slot->competencies->length / $student->todo_slots->length);
                }
            }
        }

        return $calculated_competencies;

    }//end competency_demand_algorithm()*/


    /**
     * @return StudentRepository
     */
    public function getStudents()
    {
        return $this->students;

    }//end getStudents()


    /**
     * @param StudentRepository $students
     * @return DemandController
     */
    public function setStudents($students)
    {
        $this->students = $students;
        return $this;

    }//end setStudents()


    /**
     * @return CompetencyRepository
     */
    public function getCompetencies()
    {
        return $this->competencies;

    }//end getCompetencies()


    /**
     * @param CompetencyRepository $competencies
     * @return DemandController
     */
    public function setCompetencies($competencies)
    {
        $this->competencies = $competencies;
        return $this;

    }//end setCompetencies()


}//end class
