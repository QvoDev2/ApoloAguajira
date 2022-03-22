<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEstadoToReportesPuntosControlTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reportes_puntos_control', function (Blueprint $table) {
            $table->enum('estado', ['Aprobado', 'Rechazado'])->nullable();
            $table->text('observaciones_rechazo')->nullable();
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
            $table->dropColumn(['estado', 'observaciones_rechazo']);
        });
    }
}
