<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEscoltasZonasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('escoltas_zonas', function (Blueprint $table) {
            $table->foreignId('escolta_id')->references('id')->on('escoltas')->onDelete('cascade')->onUpdate('restrict');
            $table->foreignId('zona_id')->references('id')->on('listas')->onDelete('restrict')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('escoltas_zonas');
    }
}
