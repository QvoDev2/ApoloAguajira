<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEscoltasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('escoltas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipo_contrato_id')->references('id')->on('listas')->onDelete('restrict')->onUpdate('restrict');
            $table->foreignId('tipo_escolta_id')->references('id')->on('listas')->onDelete('restrict')->onUpdate('restrict');
            $table->string('nombre', 60);
            $table->string('apellidos', 60);
            $table->string('estado', 1);
            $table->string('identificacion', 20)->unique();
            $table->string('email', 80);
            $table->datetime('confirmacion_email')->nullable();
            $table->string('ciudad_origen', 100);
            $table->string('direccion', 120);
            $table->string('celular', 10);
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
        Schema::dropIfExists('escoltas');
    }
}
