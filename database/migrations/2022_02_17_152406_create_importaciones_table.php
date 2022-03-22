<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImportacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('importaciones', function (Blueprint $table) {
            $table->id();
            $table->integer('comision_id')->nullable();
            $table->string('numero', 50)->nullable();
            $table->string('estado', 150)->nullable();
            $table->integer('grupo')->nullable();
            $table->integer('usuario_id')->nullable();
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
        Schema::dropIfExists('importaciones');
    }
}
