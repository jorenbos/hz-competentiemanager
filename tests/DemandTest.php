<?php

/**
 * TODO: Since the demand calculations are still being (re)done, this may
 * need to be remade and/or expanded once its finished.
 */

use App\Repositories\StudentRepository;
use App\Util\Constants;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class DemandTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @var StudentRepository
     */
    private $studentRepository;

    public function setUp()
    {
        parent::setUp();
        $this->studentRepository = $this->app->make('App\Repositories\StudentRepository');
    }

    /**
     * //TODO Remake once filtering had been applied.
     *
     * @return void
     */
    public function testGetStudentsForAlgorithm()
    {
        factory(App\Models\Student::class, 10)->create();
        $this->assertEquals(10, count($this->studentRepository->getAll()));
    }

    /**
     * Will test if an empty array is returned if the method is supplied with null.
     *
     * @return void
     */
    public function testGetUnCompletedCompetenciesEmpty()
    {
        $this->assertEquals([], $this->studentRepository->getUncompletedCompetencies(null));
    }

    /**
     * Will test if only uncompleted competencies by the student are returned.
     *
     * @return void
     */
    public function testGetUnCompletedCompetencies()
    {
        $student = factory(App\Models\Student::class, 1)->create();
        $competencies = factory(App\Models\Competency::class, 5)->create();
        $slot = factory(App\Models\Slot::class, 1)->create();
        $slot->competencies()->attach([
            $competencies[0]->id,
            $competencies[1]->id,
            $competencies[2]->id,
            $competencies[3]->id,
            $competencies[4]->id,
        ]);
        $student->competencies()->attach([
            [
                'competency_id' => $competencies[0]->id,
                'status'        => Constants::COMPETENCY_STATUS_DONE,
            ],
            [
                'competency_id' => $competencies[1]->id,
                'status'        => Constants::COMPETENCY_STATUS_DONE,
            ],
            [
                'competency_id' => $competencies[2]->id,
                'status'        => Constants::COMPETENCY_STATUS_DONE,
            ],
        ]);
        $this->assertEquals(2, count($this->studentRepository->getUncompletedCompetencies($student)));
    }

    /**
     * Tests if 5 slots, of which all are not done will be returned, of which all are main phase.
     *
     * @return void
     */
    public function testGetToDoSlotsAllMainNoneDone()
    {
        $student = factory(App\Models\Student::class, 1)->create([
            'starting_date' => '2015-01-01',
        ]);
        //$competencies = factory(App\Models\Competency::class,5)->create();
        $slot = factory(App\Models\Slot::class, 5)->create();
        $startDate = new \DateTime();
        $startDate->modify('+2 years');
        $endDate = new \DateTime();
        $endDate->modify('+3 years');
        $timeTable = App\Models\Timetable::create([
            'starting_date' => $startDate->format('Y-m-d'),
            'end_date'      => $endDate->format('Y-m-d'),
        ]);
        $this->assertEquals(5, count($this->studentRepository->getToDoSlots($student)));
    }

    /**
     * Will test if a propeduese student only gets propedeuse slots.
     *
     * @return void
     */
    public function testGetToDoSlotsPropedeuseStudent()
    {
        //Create a student who started 1 month ago.
        $startDateStudent = new \DateTime();
        $startDateStudent->modify('-1 month');
        $student = factory(App\Models\Student::class, 1)->create([
            'starting_date'  => $startDateStudent->format('Y-m-d'),
        ]);
        $slotMain = factory(App\Models\Slot::class, 5)->create();
        $slotProp = factory(App\Models\Slot::class, 3)->create([
            'phase' => Constants::SLOT_PHASE_PROPEDEUSE,
        ]);
        $startDate = new \DateTime();
        $startDate->modify('+1 month');
        $endDate = new \DateTime();
        $endDate->modify('+2 months');
        App\Models\Timetable::create([
            'starting_date' => $startDate->format('Y-m-d'),
            'end_date'      => $endDate->format('Y-m-d'),
        ]);
        $this->assertEquals(3, count($this->studentRepository->getToDoSlots($student)));
    }

}
