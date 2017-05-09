<?php

use Flynsarmy\CsvSeeder\CsvSeeder;

class StudentCompetenciesSeeder extends CsvSeeder
{
    public function __construct()
    {
        $this->table = 'student_competency';
        $this->filename = base_path().'/database/seeds/csv/student_competency.csv';
    }

    public function run()
    {
        DB::disableQueryLog();

        // Uncomment the below to wipe the table clean before populating
        // DB::table($this->table)->truncate();

        parent::run();
    }
}
