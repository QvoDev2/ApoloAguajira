<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportesPuntosControlTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reportes_puntos_control', function (Blueprint $table) {
            $table->id();
            $table->foreignId('punto_control_id')->nullable()->references('id')->on('puntos_control')->onDelete('restrict')->onUpdate('restrict');
            $table->foreignId('usuario_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('restrict');
            $table->double('longitud', 9, 6);
            $table->double('latitud', 9, 6);
            $table->double('precision', 4, 1)->unsigned();
            $table->text('observaciones')->nullable();
            $table->dateTime('fecha_reporte');
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
        Schema::dropIfExists('reportes_puntos_control');
    }
}
