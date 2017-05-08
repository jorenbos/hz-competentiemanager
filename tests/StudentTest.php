<?php

use App\Repositories\StudentRepository;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class StudentTest extends TestCase
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

    public function testRepositoryGetById()
    {
        $student = factory(App\Models\Student::class)->create();
        $this->assertEquals($student->id, $this->studentRepository->getById($student->id)->id);
    }

    public function testRepositoryGetAll()
    {
        factory(App\Models\Student::class, 10)->create();
        $this->assertEquals(10, count($this->studentRepository->getAll()));
    }

    public function testRepositoryCreate()
    {
        $student = $this->studentRepository->create(
            [
                'name'         => 'Henk de Lange',
                'student_code' => '00047935',
                'date_of_birth'=> '1975-09-02',
                'starting_date'=> '2010-05-13',
                'gender'       => 'female',
            ]
        );
        $this->assertEquals('Henk de Lange', $student->name);
        $this->assertEquals('00047935', $student->student_code);
        $this->assertEquals('1975-09-02', $student->date_of_birth);
        $this->assertEquals('2010-05-13', $student->starting_date);
        $this->assertEquals('female', $student->gender);
    }

    public function testRepositoryDelete()
    {
        $student = factory(App\Models\Student::class, 1)->create();
        $this->assertEquals(1, count($this->studentRepository->getAll()));
        $this->studentRepository->delete($student->id);
        $this->assertEquals(0, count($this->studentRepository->getAll()));
    }

    // public function testRelationWithCompetencies()
    // {
    //     $student = factory(App\Models\Student::class)->create();
    //     $competencyA = factory(App\Models\Competency::class)->create();
    //     $competencyB = factory(App\Models\Competency::class)->create();
    //     $competencyC = factory(App\Models\Competency::class)->create();
    //
    //     $student->competencies()->sync(
    //         [
    //         $competencyA->id => ['status'=>1],
    //         $competencyC->id => ['status'=>0],
    //         ]
    //     );
    //
    //     $this->assertEquals($student->competencies->find($competencyA->id)->cu_code, $competencyA->cu_code);
    //     $this->assertEquals($student->competencies->find($competencyB->id), null);
    //     $this->assertEquals($student->competencies->find($competencyC->id)->cu_code, $competencyC->cu_code);
    // }

    public function testRelationWithProjects()
    {
        $student = factory(App\Models\Student::class)->create();
        $projectA = factory(App\Models\Project::class)->create();
        $projectB = factory(App\Models\Project::class)->create();
        $projectC = factory(App\Models\Project::class)->create();

        $student->projects()->sync([$projectA->id, $projectC->id]);

        $this->assertEquals($student->projects->find($projectA->id)->projectnummer, $projectA->projectnummer);
        $this->assertEquals($student->projects->find($projectB->id), null);
        $this->assertEquals($student->projects->find($projectC->id)->projectnummer, $projectC->projectnummer);
    }
}
