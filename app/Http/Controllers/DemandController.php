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
        set_time_limit(0);
    }

    public function index()
    {
        return view('demand.index', ['competencies' => $this->calculateDemand()]);
    }

    public function raw()
    {
        $demandArray = $this->calculateDemand();
        return $demandArray;
    }

    private function calculateDemand()
    {
        return $this->competencyRepository->findAll()
            ->mapWithKeys(function ($competency) {
                return [$competency->name => 0];
            })
            ->pipe(function ($demandByCompetency) {
                $timetable = $this->timetableRepository->getNext();
                $this->studentRepository->getStudentsForAlgorithm($timetable)->each(function ($student) use ($timetable, $demandByCompetency) {
                    $todoSlots = $this->studentRepository->getToDoSlots($student, $timetable);
                    $todoCreditCount = $this->studentRepository->getToDoCredits($student, $todoSlots);
                    if ($todoCreditCount > 0) {
                        $todoSlots->each(function ($slot) use ($todoCreditCount, $timetable, $demandByCompetency) {
                            $ecValue = $slot->competencies->first()->ec_value;
                            $demand = ($ecValue / $todoCreditCount) * ($timetable->ec_value / $ecValue);
                            $slot->competencies->each(function ($competency) use ($demandByCompetency, $demand) {
                                $demandByCompetency[$competency->name] += $demand;
                            });
                        });
                    }
                });

                return $demandByCompetency;
            })
            ->map(function ($demand, $name) {
                $competency = $this->competencyRepository->findBy('name', $name);

                return $demand * $competency->ec_value;
            })
            ->pipe(function ($unrounded) {
                $rounder = new ProportionalRepresentation(2.5);
                // using collect and toArray because rounding engine doesn't support collections yet
                return collect($rounder->roundOff($unrounded->toArray()));
            })
            ->pipe(function ($rounded) {
                // reattatch keys (rounding engine doesn't support this yet)
                $competencyNames = $this->competencyRepository->findAll()->map(function ($comp) {
                    return $comp->name;
                })->reverse();

                return $rounded->mapWithKeys(function ($demand) use ($competencyNames) {
                    return [$competencyNames->pop() => $demand];
                });
            })
            ->map(function ($competencyDemand, $name) {
                $competency = $this->competencyRepository->findBy('name', $name);

                return $competencyDemand / $competency->ec_value;
            })
            ->sort()
            ->reverse();
    }
}
