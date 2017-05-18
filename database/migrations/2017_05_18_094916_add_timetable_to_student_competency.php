<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTimetableToStudentCompetency extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('student_competency', function (Blueprint $table) {
            $table->integer('timetable')->unsigned()->nullable();

            $table->foreign('timetable')->references('id')->on('timetables');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('student_competency', function (Blueprint $table) {
            $table->dropForeign(['timetable']);
            $table->dropColumn('timetable');
        });
    }
}
