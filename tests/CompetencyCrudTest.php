<?php

use App\Models\Competency;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CompetencyCrudTest extends TestCase
{
    use DatabaseMigrations;

    public function testIndex()
    {
        $this->mockSomeCompetencies();

        $this->visit('/competency')
            ->see('Memes Posten 1a')
            ->see('Memes Posten 1b')
            ->see('Wijn Drinken 2');
    }

    public function testShow()
    {
        $this->mockSomeCompetencies();

        $this->visit('/competency/1')
            ->see('Memes Posten 1a');
    }

    public function testEdit()
    {
        $this->mockSomeCompetencies();

        $this->visit('/competency/1/edit')
            ->see('Memes Posten 1a')
            ->see('MEME')
            ->see('blablabla')
            ->see('5')
            ->see('CU123456');
    }

    public function testUpdate()
    {
        $this->mockSomeCompetencies();

        $this->visit('/competency/1/edit')
            ->type('Memes Stelen 1a', 'name')
            ->press('Opslaan');

        $this->visit('/competency/1/edit')
            ->see('Memes Stelen 1a');
    }

    private function mockSomeCompetencies()
    {
        Competency::create(
            [
                'name'         => 'Memes Posten 1a',
                'abbreviation' => 'MEME',
                'description'  => 'blablabla',
                'ec_value'     => 5.0,
                'cu_code'      => 'CU123456',
            ]
        );

        Competency::create(
            [
                'name'         => 'Memes Posten 1b',
                'abbreviation' => 'MEMEB',
                'description'  => 'blablabla tests',
                'ec_value'     => 5.0,
                'cu_code'      => 'CU654321',
            ]
        );

        Competency::create(
            [
                'name'         => 'Wijn Drinken 2',
                'abbreviation' => 'WIJN',
                'description'  => 'drink drink drink',
                'ec_value'     => 5.0,
                'cu_code'      => 'CU456789',
            ]
        );
    }
}
