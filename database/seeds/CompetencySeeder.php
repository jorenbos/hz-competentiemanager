<?php

use Flynsarmy\CsvSeeder\CsvSeeder;

class CompetencySeeder extends CsvSeeder
{
    public function __construct()
    {
        $this->table = 'competencies';
        $this->filename = base_path() . '/database/seeds/csv/competency.csv';
    }

    public function run()
	{
		DB::disableQueryLog();

		// Uncomment the below to wipe the table clean before populating
		// DB::table($this->table)->truncate();

		parent::run();
	}
}
