<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstadosEliminadosComisionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estados_eliminados', function (Blueprint $table) {
            $table->id();
            $table->text('observaciones');
            $table->foreignId('comision_id')->references('id')->on('comisiones')->onDelete('restrict')->onUpdate('restrict');
            $table->string('estado', 2);
            $table->foreignId('usuario_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('restrict');
            $table->foreignId('usuario_elimina_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('restrict');
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
        Schema::dropIfExists('estados_eliminados');
    }
}
