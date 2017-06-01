<?php

namespace App\Http\Controllers;

use App\Repositories\CompetencyRepository;
use App\Repositories\StudentRepository;
use App\Repositories\TimetableRepository;
use App\Util\Constants;
use App\Rounding\RoundingImplementation\ProportionalRepresentation;

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
    public function __construct(
        StudentRepository $studentRepository,
        CompetencyRepository $competencyRepository,
        TimetableRepository $timetableRepository
    ) {
        $this->studentRepository = $studentRepository;
        $this->competencyRepository = $competencyRepository;
        $this->timetableRepository = $timetableRepository;
    }

    public function index()
    {
        return view('demand.index', ['competencies' => $this->calculateDemand()]);
    }

    private function calculateDemand()
    {
        $timetable = $this->timetableRepository->getNext();
        $competencyDemand = [];
        $testDemand = 0;

        foreach ($this->competencyRepository->getAll() as $competency) {
            $competencyDemand[$competency->id]['competency'] = $competency;
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
                        switch ($toDoCompetency->pickable_for_algorithm) {
                            case Constants::COMPETENCY_ALGORITHM_ALLOWED_NORMAL:
                                $competencyDemand[$toDoCompetency->id]['mean_demand'] += $slotDemand / count($toDoSlot->competencies);
                                $testDemand += ($slotDemand / count($toDoSlot->competencies)) * $slot_ec_value;
                                break;
                            case Constants::COMPETENCY_ALGORITHM_ALLOWED_MANDATORY:
                                $competencyDemand[$toDoCompetency->id]['mean_demand'] += 1;
                                $testDemand += $slot_ec_value;
                                break;
                        }
                    }
                }
            }
        }

        $unroundedDemand = [];
        foreach ($competencyDemand as $competencyId) {
            $unroundedDemand[array_search($competencyId, $competencyDemand)] = $competencyId['mean_demand'] * $competencyId['competency']->ec_value;
        }

        $rounder = new ProportionalRepresentation(2.5);
        $roundedDemand = $rounder->roundOff($unroundedDemand);
        $i = 0;
        foreach ($this->competencyRepository->getAll() as $competency) {
            $competencyDemand[$competency->id]['mean_demand'] = $roundedDemand[$i] / $competency->ec_value;
            $i++;
        }
        var_dump($testDemand);
        return $competencyDemand;
    }
}
