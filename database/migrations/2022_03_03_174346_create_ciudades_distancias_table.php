<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCiudadesDistanciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ciudades_distancias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('origen_id')->references('id')->on('ciudades')->onDelete('restrict')->onUpdate('restrict');
            $table->foreignId('destino_id')->references('id')->on('ciudades')->onDelete('restrict')->onUpdate('restrict');
            $table->double('distancia', 8, 2)->nullable();
            $table->integer('peso')->default(0)->nullable();
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
        Schema::dropIfExists('ciudades_distancias');
    }
}
