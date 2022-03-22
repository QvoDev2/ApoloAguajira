<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmpresaToEscoltasTableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('escoltas', function (Blueprint $table) {
            $table->foreignId('empresa_id')->nullable()->references('id')->on('listas')->onDelete('restrict')->onUpdate('restrict');
            $table->foreignId('banco_id')->nullable()->references('id')->on('listas')->onDelete('restrict')->onUpdate('restrict');
            $table->foreignId('tipo_cuenta_id')->nullable()->references('id')->on('listas')->onDelete('restrict')->onUpdate('restrict');
            $table->string('numero_cuenta', 20)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('escoltas', function (Blueprint $table) {
            $table->dropColumn('empresa_id');
            $table->dropColumn('banco_id');
            $table->dropColumn('tipo_cuenta_id');
            $table->dropColumn('numero_cuenta');
        });
    }
}
