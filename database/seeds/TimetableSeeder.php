<?php

use Flynsarmy\CsvSeeder\CsvSeeder;

class TimetableSeeder extends CsvSeeder
{
    public function __construct()
    {
        $this->table = 'timetables';
        $this->filename = base_path().'/database/seeds/csv/timetables.csv';
    }

    public function run()
    {
        DB::disableQueryLog();

        // Uncomment the below to wipe the table clean before populating
        // DB::table($this->table)->truncate();

        parent::run();
    }
}
