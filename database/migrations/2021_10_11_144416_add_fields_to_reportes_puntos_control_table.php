<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToReportesPuntosControlTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reportes_puntos_control', function (Blueprint $table) {
            $table->mediumText('observaciones_fuera_radio')->nullable();
            $table->foreignId('usuario_asigna_id')->nullable()->references('id')->on('users')->onDelete('restrict')->onUpdate('restrict');
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
            $table->dropForeign('reportes_puntos_control_usuario_asigna_id_foreign');
            $table->dropColumn(['observaciones_fuera_radio', 'usuario_asigna_id']);
        });
    }
}
