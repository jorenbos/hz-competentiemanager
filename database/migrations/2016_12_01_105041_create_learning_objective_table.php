<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLearningObjectiveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('learning_objectives', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('competency_id')
                ->unsigned()
                ->nullable();
            $table->foreign('competency_id')
                ->references('id')
                ->on('competencies')
                ->onDelete('cascade');
            $table->string('description');
            $table->string('elucidation');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('learning_objectives');
    }
}
