<?php

namespace App\Http\Controllers;

use App\Repositories\CompetencyRepository;
use App\Repositories\StudentRepository;
use App\Repositories\TimetableRepository;
use App\Util\Constants;

class DemandController extends Controller
{
    /**
     * @var StudentRepository
     */
    private $studentRepository;

    /**
     * @var CompetencyRepository
     */
    private $competencyRepository;

    /**
     * @var CompetencyRepository
     */
    private $timetableRepository;

    /**
     * Inject UserRepository and CompetencyRepository dependencies.
     *
     * @param StudentRepository    $studentRepository
     * @param CompetencyRepository $competencyRepository
     */
    public function __construct(StudentRepository $studentRepository, CompetencyRepository $competencyRepository, TimetableRepository $timetableRepository)
    {
        $this->studentRepository = $studentRepository;
        $this->competencyRepository = $competencyRepository;
        $this->timetableRepository = $timetableRepository;
    }

//end __construct()

    public function index()
    {
        return view('demand.index', ['competencies' => $this->calculateDemand()]);
    }

//end index()

//end calculate()

    private function calculateDemand()
    {
        $timetable = $this->timetableRepository->getNext();
        $competencyDemand = [];

        foreach ($this->competencyRepository->getAll() as $competency) {
            $competencyDemand[$competency->id]['competency'] = $competency;
            $competencyDemand[$competency->id]['count'] = 0;
            $competencyDemand[$competency->id]['mean_demand'] = 0;
        }

        foreach ($this->studentRepository->getStudentsForAlgorithm($timetable) as $student) {
            $toDoSlots = $this->studentRepository->getToDoSlots($student, $timetable);
            $toDoCredits = $this->studentRepository->getToDoCredits($student, $toDoSlots);

            if ($toDoCredits > 0) {
                foreach ($toDoSlots as $toDoSlot) {
                    $keysToDoSlotCompetencies = array_keys($toDoSlot->competencies->toArray());
                    $slot_ec_value = $toDoSlot->competencies[$keysToDoSlotCompetencies[0]]->ec_value;
                    $slotDemand = ($slot_ec_value / $toDoCredits) * ($timetable->ec_value / $slot_ec_value);

                    foreach ($toDoSlot->competencies as $toDoCompetency) {
                        $competencyDemand[$toDoCompetency->id]['mean_demand'] += $slotDemand / count($toDoSlot->competencies);
                    }
                }
            }
        }

        return $competencyDemand;
    }
}//end class
