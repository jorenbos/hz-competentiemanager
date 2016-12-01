<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompetencyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('competencies', function (Blueprint $table) {
          $table->increments('id');
          $table->string('name');
          $table->string('abbreviation');
          $table->text('description');
          $table->float('EC-value');
          $table->string('CU-code');
          $table->timestamps();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::drop('competencies');
    }
}
