<?php

namespace App\Http\Controllers;

use App\Repositories\CompetencyRepository;
use App\Repositories\StudentRepository;
use App\Repositories\TimetableRepository;
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
                        $competencyDemand[$toDoCompetency->id]['mean_demand'] += $slotDemand / count($toDoSlot->competencies);
                    }
                }
            }
        }
        dd('herro');

        $unroundedDemand = array_map(
            function ($value) {
                return [
                    'demand'    => $value['mean_demand'],
                    'ec_value'  => $value['competency']->ec_value,
                ];
            }, $competencyDemand
        );

        $rounder = new ProportionalRepresentation();
        $roundedDemand = $rounder->roundOff($unroundedDemand);
        $i = 1;
        foreach ($this->competencyRepository->getAll() as $competency) {
            $competencyDemand[$competency->id]['mean_demand'] = $roundedDemand[$competency->id]['demand'];
            $i++;
        }

        return $competencyDemand;
    }
}
