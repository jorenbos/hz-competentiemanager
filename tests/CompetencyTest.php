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

		$competency->projects()->sync([
			$projectA->id => ['amount'=>3], 
			$projectC->id => ['amount'=>4]
		]);

		$this->assertEquals($competency->projects->find($projectA->id)->projectnumber, $projectA->projectnumber);
		$this->assertEquals($competency->projects->find($projectB->id), null);
		$this->assertEquals($competency->projects->find($projectC->id)->projectnumber, $projectC->projectnumber);

	}

}
