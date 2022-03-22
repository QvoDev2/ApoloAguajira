<?php

use Illuminate\Database\Migrations\Migration;

class CreateVcomisionesTableView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE OR REPLACE VIEW vcomisiones_table as select `c`.`id` AS `id`,`c`.`paso_creacion` AS `paso_creacion`,`c`.`numero` AS `numero`,`c`.`fecha_aprobacion_correo` AS `fecha_aprobacion_correo`,`c`.`fecha_inicio` AS `fecha_inicio`,`c`.`fecha_fin` AS `fecha_fin`,`c`.`valor_x_dia` AS `valor_x_dia`,`c`.`observaciones` AS `observaciones`,`c`.`cliente_id` AS `cliente_id`,`c`.`usuario_id` AS `usuario_id`,`c`.`created_at` AS `created_at`,`c`.`updated_at` AS `updated_at`,`c`.`dias_aprobados` AS `dias_aprobados`,`c`.`dias_reales` AS `dias_reales`,`c`.`viajero` AS `viajero`,`c`.`origen` AS `origen`,`c`.`tipo` AS `tipo`,`c`.`tipo_desplazamiento_id` AS `tipo_desplazamiento_id`,concat(`e`.`nombre`,' ',`e`.`apellidos`) AS `nombre_escolta`,`e`.`identificacion` AS `identificacion_escolta`,`cli`.`nombre` AS `nombre_cliente`,`c`.`zona_id` AS `zona_id`,(select count(`r`.`id`) from `reportes_puntos_control` `r` where `r`.`comision_id` = `c`.`id` and `r`.`punto_control_id` is null) AS `novedades`,ifnull((select `ec`.`estado` from `estados_comisiones` `ec` where `c`.`id` = `ec`.`comision_id` order by `ec`.`created_at` desc,`ec`.`id` desc limit 1),0) AS `estado` from (((`comisiones` `c` join `clientes` `cli` on(`cli`.`id` = `c`.`cliente_id`)) left join `vehiculos_escoltas` `ve` on(`c`.`id` = `ve`.`comision_id`)) left join `escoltas` `e` on(`e`.`id` = `ve`.`escolta_id`)) group by `c`.`id`");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW vcomisiones_table');
    }
}
