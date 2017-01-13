<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Repositories\StudentRepository;

class StudentTest extends TestCase
{
    use DatabaseMigrations;

    public function testRepositoryGetById()
    {
        $studentRepository = new StudentRepository();
        $student = factory(App\Models\Student::class)->create();
        $this->assertEquals($student->id, $studentRepository->getById($student->id)->id);
    }

    public function testRepositoryGetAll()
    {
        $studentRepository = new StudentRepository();
        factory(App\Models\Student::class, 10)->create();
        $this->assertEquals(10, count($studentRepository->getAll()));
    }

    public function testRepositoryCreate()
    {
        $studentRepository = new StudentRepository();
        $student = $studentRepository->create(
            [
                'name' => 'Henk de Lange',
                'student_code'=> '00047935',
                'date_of_birth'=> '1975-09-02',
                'starting_date'=> '2010-05-13',
                'gender' => 'female'
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
        $studentRepository = new StudentRepository();
        $student = factory(App\Models\Student::class, 1)->create();
        $this->assertEquals(1,count($studentRepository->getAll()));
        $studentRepository->delete($student->id);
        $this->assertEquals(0,count($studentRepository->getAll()));
    }

    public function testRelationWithCompetencies()
    {
        $student = factory(App\Models\Student::class)->create();
        $competencyA = factory(App\Models\Competency::class)->create();
        $competencyB = factory(App\Models\Competency::class)->create();
        $competencyC = factory(App\Models\Competency::class)->create();

        $student->competencies()->sync(
            [
            $competencyA->id => ['status'=>1],
            $competencyC->id => ['status'=>0]
            ]
        );

        $this->assertEquals($student->competencies->find($competencyA->id)->cu_code, $competencyA->cu_code);
        $this->assertEquals($student->competencies->find($competencyB->id), null);
        $this->assertEquals($student->competencies->find($competencyC->id)->cu_code, $competencyC->cu_code);

    }

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
