<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCompetenciesPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('competencies_prerequisites', function (Blueprint $table) {
            $table->integer('competency_id')->unsigned();
            $table->integer('competency_prerequisite_id')->unsigned()->nullable();
            $table->integer('rule');
            $table->integer('amount_required')->nullable();

            $table->foreign('competency_id')->references('id')->on('competencies');
            $table->foreign('competency_prerequisite_id')->references('id')->on('competencies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('competencies_prerequisites');
    }
}
