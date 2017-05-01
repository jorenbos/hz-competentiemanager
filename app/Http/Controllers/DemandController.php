<?php

namespace App\Http\Controllers;

use App\Repositories\CompetencyRepository;
use App\Repositories\SlotRepository;
use App\Repositories\StudentRepository;
use App\Util\Constants;

class DemandController extends Controller
{
    /**
     * @var StudentRepository
     */
    protected $students;

    /**
     * @var SlotRepository
     */
    protected $slots;

    /**
     * @var CompetencyRepository
     */
    protected $competencies;

    /**
     * Inject UserRepository and CompetencyRepository dependencies.
     *
     * @param StudentRepository    $studentRepository
     * @param CompetencyRepository $competencyRepository
     */
    public function __construct(StudentRepository $studentRepository, SlotRepository $slotRepository, CompetencyRepository $competencyRepository)
    {
        $this->setStudents($studentRepository);
        $this->setSlots($slotRepository);
        $this->setCompetencies($competencyRepository);
    }

//end __construct()

    public function index()
    {
        // $this->getStudents()->getToDoSlots(1);
        return view('demand.index', ['competencies' => $this->calculateDemand()]);
    }

//end index()

    public function calculate()
    {
        $competencyCount = [];

        $students = $this->getStudents()->getAll();

        foreach ($students as $student) {
            foreach ($this->students->getUncompletedCompetencies($student) as $competency) {
                $competencyCount[$competency->id]['competency'] = $competency;
                if (!array_key_exists('count', $competencyCount[$competency->id])) {
                    $competencyCount[$competency->id]['count'] = 0;
                }

                if (!array_key_exists('mean_demand', $competencyCount[$competency->id])) {
                    $competencyCount[$competency->id]['mean_demand'] = 0;
                }

                $competencyCount[$competency->id]['count'] += 1;
                $competenciesPerStudentPerblock = 2;
                $competenciesTodo = count($this->students->getUncompletedCompetencies($student));
                $competencyCount[$competency->id]['mean_demand'] += ($competenciesPerStudentPerblock / $competenciesTodo);
            }
        }

        return $competencyCount;
    }

//end calculate()

    private function calculateDemand()
    {
        $competencyDemand = [];

        foreach ($this->getCompetencies()->getAll() as $competency) {
            $competencyDemand[$competency->id]['competency'] = $competency;
            $competencyDemand[$competency->id]['count'] = 0;
            $competencyDemand[$competency->id]['mean_demand'] = 0;
        }

        foreach ($this->getStudents()->getStudentsForAlgorithm() as $student) {
            $toDoSlots = $this->getStudents()->getToDoSlots($student);
            $toDoCredits = $this->students->getToDoCredits($student, $toDoSlots);

            if ($toDoCredits > 0) {
                foreach ($toDoSlots as $toDoSlot) {
                    $keysToDoSlotCompetencies = array_keys($toDoSlot->competencies->toArray());
                    $slot_ec_value = $toDoSlot->competencies[$keysToDoSlotCompetencies[0]]->ec_value;
                    $slotDemand = ($slot_ec_value / $toDoCredits) * (Constants::TIMEFRAME_EC_TOTAL / $slot_ec_value);

                    foreach ($toDoSlot->competencies as $toDoCompetency) {
                        $competencyDemand[$toDoCompetency->id]['mean_demand'] += $slotDemand / count($toDoSlot->competencies);
                    }
                }
            }

            // if ($toDoCredits > 0) {
            //     foreach ($this->students->getUncompletedCompetencies($student) as $competency) {
            //         $slotValue = 0;
            //         $matching_comp = $student->competencies()->find($competency->id);
            //         if ($matching_comp != null) {
            //             if ($matching_comp->pivot->status == Constants::COMPETENCY_STATUS_HALF_DOING ||
            //             $matching_comp->pivot->status == Constants::COMPETENCY_STATUS_HALF_DONE) {
            //                 $slotValue = $competency->ec_value/2;
            //             }
            //         } else {
            //             $slotValue = $competency->ec_value;
            //         }
            //         //TODO: 2.5 veranderen in configuratie variable.
            //         $competencyDemand[$competency->id]['mean_demand'] += 2.5 * ($slotValue / $toDoCredits);
            //     }
            // }
        }

        return $competencyDemand;
    }

//end calculateDemand()

    /**
     * @return StudentRepository
     */
    public function getStudents()
    {
        return $this->students;
    }

//end getStudents()

    /**
     * @param StudentRepository $students
     *
     * @return DemandController
     */
    public function setStudents($students)
    {
        $this->students = $students;

        return $this;
    }

//end setStudents()

/**
 * @return SlotRepository
 */
public function getSlots()
{
    return $this->slots;
}

/**
 * @param SlotRepository $slots
 *
 * @return DemandController
 */
public function setSlots($slots)
{
    $this->slots = $slots;

    return $this;
}

    /**
     * @return CompetencyRepository
     */
    public function getCompetencies()
    {
        return $this->competencies;
    }

//end getCompetencies()

    /**
     * @param CompetencyRepository $competencies
     *
     * @return DemandController
     */
    public function setCompetencies($competencies)
    {
        $this->competencies = $competencies;

        return $this;
    }

//end setCompetencies()
}//end class
