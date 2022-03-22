<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevolucionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devoluciones', function (Blueprint $table) {
            $table->id();
            $table->double('valor', 9, 0)->unsigned();
            $table->date('fecha')->nullable();
            $table->string('tipo', 150)->nullable();
            $table->string('numero', 150)->nullable();
            $table->string('observaciones', 450)->nullable();
            $table->foreignId('comision_id')->nullable()->references('id')->on('comisiones')->onDelete('restrict')->onUpdate('restrict');
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
        Schema::dropIfExists('devoluciones');
    }
}
