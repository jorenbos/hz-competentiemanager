<?php

use Flynsarmy\CsvSeeder\CsvSeeder;

class CompetencyPrerequisitesSeeder extends CsvSeeder
{
    public function __construct()
    {
        //TODO: add new competencies
        $this->table = 'competencies_prerequisites';
        $this->filename = base_path().'/database/seeds/csv/competency_preqs.csv';
    }

    public function run()
    {
        DB::disableQueryLog();

        // Uncomment the below to wipe the table clean before populating
        // DB::table($this->table)->truncate();

        parent::run();
    }
}
