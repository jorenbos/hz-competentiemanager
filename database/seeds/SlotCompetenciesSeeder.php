<?php

use Flynsarmy\CsvSeeder\CsvSeeder;

class SlotCompetenciesSeeder extends CsvSeeder
{
    public function __construct()
    {
        $this->table = 'slots_competencies';
        $this->filename = base_path() . '/database/seeds/csv/slots_competencies.csv';
    }

    public function run()
	{
		DB::disableQueryLog();

		// Uncomment the below to wipe the table clean before populating
		// DB::table($this->table)->truncate();

		parent::run();
	}
}
