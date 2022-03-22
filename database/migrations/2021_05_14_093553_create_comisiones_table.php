<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComisionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comisiones', function (Blueprint $table) {
            $table->id();
            $table->string('paso_creacion', 1)->default('2');
            $table->string('numero', 20)->nullable();
            $table->date('fecha_aprobacion_correo');
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->double('valor_x_dia', 8, 0)->unsigned();
            $table->text('observaciones')->nullable();
            $table->foreignId('cliente_id')->references('id')->on('clientes')->onDelete('restrict')->onUpdate('restrict');
            $table->foreignId('usuario_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('restrict');
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
        Schema::dropIfExists('comisiones');
    }
}
