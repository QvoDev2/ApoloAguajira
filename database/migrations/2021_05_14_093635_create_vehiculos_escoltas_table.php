<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiculosEscoltasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehiculos_escoltas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('comision_id')->references('id')->on('comisiones')->onDelete('restrict')->onUpdate('restrict');
            $table->foreignId('vehiculo_id')->nullable()->references('id')->on('vehiculos')->onDelete('restrict')->onUpdate('restrict');
            $table->foreignId('escolta_id')->references('id')->on('escoltas')->onDelete('restrict')->onUpdate('restrict');
            $table->string('codigo_autorizacion', 20);
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
        Schema::dropIfExists('vehiculos_escoltas');
    }
}
