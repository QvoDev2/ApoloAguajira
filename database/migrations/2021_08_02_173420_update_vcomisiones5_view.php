<?php

use Illuminate\Database\Migrations\Migration;

class UpdateVcomisiones5View extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            CREATE OR REPLACE VIEW vcomisiones AS
            SELECT
                c.*,
                CONCAT(e.nombre, ' ', e.apellidos) nombre_escolta,
                e.identificacion identificacion_escolta,
                CONCAT(u.nombres, ' ', u.apellidos) nombre_usuario,
                cli.nombre nombre_cliente,
                IFNULL((SELECT estado FROM estados_comisiones ec WHERE c.id = ec.comision_id ORDER BY created_at DESC LIMIT 1), 0) estado
            FROM comisiones c
            INNER JOIN users u ON u.id = c.usuario_id
            INNER JOIN clientes cli ON cli.id = c.cliente_id
            INNER JOIN vehiculos_escoltas ve ON c.id = ve.comision_id
            INNER JOIN escoltas e ON e.id = ve.escolta_id
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
            CREATE OR REPLACE VIEW vcomisiones AS
            SELECT
                c.*,
                CONCAT(u.nombres, ' ', u.apellidos) nombre_usuario,
                cli.nombre nombre_cliente,
                IFNULL((SELECT estado FROM estados_comisiones ec WHERE c.id = ec.comision_id ORDER BY created_at DESC LIMIT 1), 0) estado
            FROM comisiones c
            INNER JOIN users u ON u.id = c.usuario_id
            INNER JOIN clientes cli ON cli.id = c.cliente_id
        ");
    }
}
