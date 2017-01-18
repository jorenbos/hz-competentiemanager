<?php

use App\Models\Project;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProjectCrudTest extends TestCase
{
    use DatabaseMigrations;

    public function testIndex()
    {
        $this->mockSomeProjects();

        $this->visit('/project')
            ->see('Competentie Manager')
            ->see('Wijn Proeven')
            ->see('Make America Great Again');
    }

    public function testEdit()
    {
        $this->mockSomeProjects();

        $this->visit('/project/1/edit')
            ->see('Competentie Manager');
    }

    private function mockSomeProjects()
    {
        Project::create(
            [
                'name'          => 'Competentie Manager',
                'projectnumber' => '123456',
                'description'   => 'Super cool project met leuke mensen',
            ]
        );

        Project::create(
            [
                'name'          => 'Wijn Proeven',
                'projectnumber' => '654321',
                'description'   => 'Project speciaal voor de wijn kenners',
            ]
        );

        Project::create(
            [
                'name'          => 'Make America Great Again',
                'projectnumber' => '42069',
                'description'   => 'Internationaal project',
            ]
        );
    }
}
