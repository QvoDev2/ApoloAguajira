<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListasTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listas', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 50)->nullable();
            $table->string('nombre', 50);
            $table->text('descripcion')->nullable();
            $table->foreignId('lista_id')->nullable()->references('id')->on('listas')->onDelete('restrict')->onUpdate('restrict');
            $table->foreignId('tipo_lista_id')->references('id')->on('tipo_listas')->onDelete('restrict')->onUpdate('restrict');
            $table->string('editable', 1)->default('1');
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
        Schema::drop('listas');
    }
}
