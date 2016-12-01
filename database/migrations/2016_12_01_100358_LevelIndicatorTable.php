<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class LevelIndicatorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('level_indicators', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('objective_id')
                ->unsigned()
                ->nullable();
            $table->foreign('objective_id')
                ->references('id')
                ->on('learning_objectives')
                ->onDelete('cascade');
            $table->string('indicator_code');
            $table->string('description');

        });
        //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
