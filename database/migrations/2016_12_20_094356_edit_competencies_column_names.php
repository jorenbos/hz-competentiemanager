<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditCompetenciesColumnNames extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('competencies', function (Blueprint $table) {
            $table->dropColumn('ec-value');
            $table->float('ec_value');
            $table->dropColumn('cu-code');
            $table->string('cu_code');
            // $table->renameColumn("ec-value", "ec_value");
            // $table->renameColumn("cu-code", "cu_code");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('competencies', function (Blueprint $table) {
            $table->dropColumn('ec_value');
            $table->float('ec-value');
            $table->dropColumn('cu_code');
            $table->string('cu-code');
            // $table->renameColumn("ec_value", "'ec-value'");
            // $table->renameColumn("cu_code", "cu-code");
        });
    }
}
