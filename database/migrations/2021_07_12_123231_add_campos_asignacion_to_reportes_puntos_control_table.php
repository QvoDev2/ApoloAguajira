<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCamposAsignacionToReportesPuntosControlTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reportes_puntos_control', function (Blueprint $table) {
            $table->double('longitud_asignacion', 9, 6)->nullable();
            $table->double('latitud_asignacion', 9, 6)->nullable();
            $table->string('editado', 1)->nullable();
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
            $table->dropColumn(['longitud_asignacion', 'latitud_asignacion', 'editado']);
        });
    }
}
