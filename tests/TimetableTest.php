<?php

use App\Repositories\TimetableRepository;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class TimetableTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @var TimetableRepository
     */
    private $timetableRepository;

    public function setUp()
    {
        parent::setUp();
        $this->timetableRepository = $this->app->make('App\Repositories\TimetableRepository');
    }

    public function testGetByID()
    {
        $timetable = factory(App\Models\Timetable::class)->create();
        $this->assertEquals($timetable->id, $this->timetableRepository->
            getById($timetable->id)->id);
    }

    public function testGetAll()
    {
        factory(App\Models\Timetable::class, 10)->create();
        $this->assertEquals(10, count($this->timetableRepository->getAll()));
    }

    public function testCreate()
    {
        $timetable = $this->timetableRepository->create(
            [
                'starting_date' => '1997-10-04',
                'end_date'      => '1998-04-10',
            ]
        );
        $this->assertEquals('1997-10-04', $timetable->starting_date);
        $this->assertEquals('1998-04-10', $timetable->end_date);
    }
}
