<?php

use Flynsarmy\CsvSeeder\CsvSeeder;

class StudentSeeder extends CsvSeeder
{
    public function __construct()
    {
        $this->table = 'students';
        $this->filename = base_path() . '/database/seeds/csv/students.csv';
    }

    public function run()
	{
		DB::disableQueryLog();

		// Uncomment the below to wipe the table clean before populating
		// DB::table($this->table)->truncate();

		parent::run();
	}
}
