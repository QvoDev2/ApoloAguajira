<?php

use Illuminate\Database\Migrations\Migration;

class CreateMotivosRetiro extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            INSERT INTO `tipo_listas` (`id`, `codigo`, `nombre`, `descripcion`) VALUES
            (8, 'MOTIVOS_RECHAZO', 'MOTIVOS DE RECHAZO', 'Motivos de rechazo de las comisiones')
        ");

        DB::statement("
            INSERT INTO `listas` (`codigo`, `nombre`, `descripcion`, `lista_id`, `tipo_lista_id`, `editable`) VALUES
            (null, 'FOTO', null, null, 8, '1'),
            (null, 'COORDENADAS', null, null, 8, '1'),
            (null, 'NO REPORTE', null, null, 8, '1'),
            (null, 'LEGALIZA PARCIALMENTE', null, null, 8, '1'),
            (null, 'FECHAS', null, null, 8, '1')
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("
            DELETE FROM tipo_listas WHERE id = 8;
            DELETE FROM listas WHERE tipo_lista_id = 8;
        ");
    }
}
