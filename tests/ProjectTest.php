<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProjectTest extends TestCase
{
use DatabaseMigrations;

	public function testRelationWithCompetencies()
	{
		$project = factory(App\Models\Project::class)->create();
		$competencyA = factory(App\Models\Competency::class)->create();
		$competencyB = factory(App\Models\Competency::class)->create();
		$competencyC = factory(App\Models\Competency::class)->create();

		$project->competencies()->sync([
			$competencyA->id => ['amount'=>3], 
			$competencyC->id => ['amount'=>4]
		]);

		$this->assertEquals($project->competencies->find($competencyA->id)->cu_code, $competencyA->cu_code);
		$this->assertEquals($project->competencies->find($competencyB->id), null);
		$this->assertEquals($project->competencies->find($competencyC->id)->cu_code, $competencyC->cu_code);

	}

	public function testRelationWithStudents()
	{
		$project = factory(App\Models\Project::class)->create();
		$studentA = factory(App\Models\Student::class)->create();
		$studentB = factory(App\Models\Student::class)->create();
		$studentC = factory(App\Models\Student::class)->create();

		$project->students()->sync([$studentA->id, $studentC->id]);

		$this->assertEquals($project->students->find($studentA->id)->student_code, $studentA->student_code);
		$this->assertEquals($project->students->find($studentB->id), null);
		$this->assertEquals($project->students->find($studentC->id)->student_code, $studentC->student_code);
	}
}
