<?php

use Flynsarmy\CsvSeeder\CsvSeeder;

class SlotSeeder extends CsvSeeder
{
    public function __construct()
    {
        $this->table = 'slots';
        $this->filename = base_path().'/database/seeds/csv/Slots.csv';
    }

    public function run()
    {
        DB::disableQueryLog();

        // Uncomment the below to wipe the table clean before populating
        // DB::table($this->table)->truncate();

        parent::run();
    }
}
