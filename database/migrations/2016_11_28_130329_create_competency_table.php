<?php

use App\Util\Constants;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

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
            $table->float('ec-value');
            $table->string('cu-code');
            $table->integer('pickable_for_algorithm')->default(Constants::COMPETENCY_ALGORITHIM_ALLOWED_TRUE);
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
