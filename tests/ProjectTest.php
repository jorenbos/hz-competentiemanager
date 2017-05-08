<?php

use App\Repositories\ProjectRepository;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProjectTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @var ProjectRepository
     */
    private $projectRepository;

    public function setUp()
    {
        parent::setUp();
        $this->projectRepository = $this->app->make('App\Repositories\ProjectRepository');
    }

    public function testRepositoryGetById()
    {
        $project = factory(App\Models\Project::class)->create();
        $this->assertEquals($project->id, $this->projectRepository->getById($project->id)->id);
    }

    public function testRepositoryGetAll()
    {
        factory(App\Models\Project::class, 10)->create();
        $this->assertEquals(10, count($this->projectRepository->getAll()));
    }

    public function testRepositoryCreate()
    {
        $project = $this->projectRepository->create(
            [
                'name'          => 'Cool Project',
                'projectnumber' => 7,
                'description'   => 'Project for all the cool people.',
            ]
        );
        $this->assertEquals('Cool Project', $project->name);
        $this->assertEquals('7', $project->projectnumber);
        $this->assertEquals('Project for all the cool people.', $project->description);
    }

    public function testRepositoryDelete()
    {
        $project = factory(App\Models\Project::class)->create();
        $this->assertEquals(1, count($this->projectRepository->getAll()));
        $this->projectRepository->delete($project->id);
        $this->assertEquals(0, count($this->projectRepository->getAll()));
    }

    public function testRelationWithCompetencies()
    {
        $project = factory(App\Models\Project::class)->create();
        $competencyA = factory(App\Models\Competency::class)->create();
        $competencyB = factory(App\Models\Competency::class)->create();
        $competencyC = factory(App\Models\Competency::class)->create();

        $project->competencies()->sync(
            [
            $competencyA->id => ['amount'=>3],
            $competencyC->id => ['amount'=>4],
            ]
        );

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
