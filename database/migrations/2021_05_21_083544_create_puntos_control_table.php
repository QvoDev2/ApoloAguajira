<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePuntosControlTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('puntos_control', function (Blueprint $table) {
            $table->id();
            $table->foreignId('comision_id')->references('id')->on('comisiones')->onDelete('restrict')->onUpdate('restrict');
            $table->integer('orden');
            $table->double('longitud', 9, 6)->nullable();
            $table->double('latitud', 9, 6)->nullable();
            $table->string('lugar', 45);
            $table->foreignId('departamento_id')->references('id')->on('listas')->onDelete('restrict')->onUpdate('restrict');
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
        Schema::dropIfExists('puntos_control');
    }
}
