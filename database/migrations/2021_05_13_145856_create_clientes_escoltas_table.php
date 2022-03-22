<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesEscoltasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes_escoltas', function (Blueprint $table) {
            $table->foreignId('cliente_id')->references('id')->on('clientes')->onDelete('cascade')->onUpdate('restrict');
            $table->foreignId('escolta_id')->references('id')->on('escoltas')->onDelete('restrict')->onUpdate('restrict');
            $table->date('fecha_vinculacion');
            $table->date('fecha_retiro')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clientes_escoltas');
    }
}
