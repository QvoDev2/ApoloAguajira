<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuariosZonasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios_zonas', function (Blueprint $table) {
            $table->foreignId('usuario_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('restrict');
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
        Schema::dropIfExists('usuarios_zonas');
    }
}
