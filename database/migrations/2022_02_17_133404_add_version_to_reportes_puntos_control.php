<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVersionToReportesPuntosControl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reportes_puntos_control', function (Blueprint $table) {
            $table->string('version', 150)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reportes_puntos_control', function (Blueprint $table) {
            $table->dropColumn('version');
        });
    }
}
