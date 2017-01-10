<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StudentTest extends TestCase
{
    use DatabaseMigrations;

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
