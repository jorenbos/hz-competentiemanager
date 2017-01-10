<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CompetencyTest extends TestCase
{
    use DatabaseMigrations;

    public function testRelationWithProjects()
    {
        $competency = factory(App\Models\Competency::class)->create();
        $projectA = factory(App\Models\Project::class)->create();
        $projectB = factory(App\Models\Project::class)->create();
        $projectC = factory(App\Models\Project::class)->create();

        $competency->projects()->sync(
            [
            $projectA->id => ['amount'=>3], 
            $projectC->id => ['amount'=>4]
            ]
        );

        $this->assertEquals($competency->projects->find($projectA->id)->projectnumber, $projectA->projectnumber);
        $this->assertEquals($competency->projects->find($projectB->id), null);
        $this->assertEquals($competency->projects->find($projectC->id)->projectnumber, $projectC->projectnumber);

    }

    public function testRelationWithStudents()
    {
        $competency = factory(App\Models\Competency::class)->create();
        $studentA = factory(App\Models\Student::class)->create();
        $studentB = factory(App\Models\Student::class)->create();
        $studentC = factory(App\Models\Student::class)->create();

        $competency->students()->sync(
            [
            $studentA->id => ['status'=>0], 
            $studentC->id => ['status'=>0]
            ]
        );

        $this->assertEquals($competency->students->find($studentA->id)->student_code, $studentA->student_code);
        $this->assertEquals($competency->students->find($studentB->id), null);
        $this->assertEquals($competency->students->find($studentC->id)->student_code, $studentC->student_code);
    }

}
