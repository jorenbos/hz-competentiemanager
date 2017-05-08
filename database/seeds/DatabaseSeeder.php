<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(StudentSeeder::class);
        $this->call(SlotSeeder::class);
        $this->call(CompetencySeeder::class);
        $this->call(StudentCompetenciesSeeder::class);
        $this->call(SlotCompetenciesSeeder::class);
    }
}
