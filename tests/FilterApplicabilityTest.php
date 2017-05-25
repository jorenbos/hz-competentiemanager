<?php

use App\Competencies\Filters\ApplicabilityFilter;
use App\Models\Competency;

use Illuminate\Foundation\Testing\WithoutMiddleware;
// use Illuminate\Foundation\Testing\DatabaseMigrations;
// use Illuminate\Foundation\Testing\DatabaseTransactions;

class FilterApplicabilityTest extends TestCase
{
    protected $competencyMock;

    public function setUp()
    {
        parent::setUp();
        $this->competencyMock = \Mockery::mock(Competency::class)->makePartial();
    }

    public function testEmptyFilterApplicabiliy()
    {
        $this->assertEquals(collect(), ApplicabilityFilter::filterApplicability([]) );
    }

    public function testOneCompetencyNoSequeniality()
    {
        $this->competencyMock->shouldReceive('sequentiality')->andReturn([]);
        $this->app->instance(Competency::class, $this->competencyMock);

        $competencies = $this->app->make(Competency::class);
        $this->assertEquals(collect($competencies), ApplicabilityFilter::filterApplicability(collect($competencies)));
    }

    // public function testOneCompetencyOneRuleZero()
    // {
    //     $this->competencyMock->shouldReceive('sequentiality')->andReturn([]);
    //     $this->app->instance(Competency::class, $this->competencyMock);
    //
    //     $competencies = $this->app->make(Competency::class);
    //     $this->assertEquals(collect($competencies), ApplicabilityFilter::filterApplicability(collect($competencies)));
    // }
}
