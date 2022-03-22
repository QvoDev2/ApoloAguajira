<?php

use Illuminate\Database\Seeder;

class TipoDesplazamiento extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("
            INSERT INTO `tipo_listas` (`id`, `codigo`, `nombre`, `descripcion`) VALUES
            (9, 'TIPOS_DESPLAZAMIENTO', 'TIPOS DESPLAZAMIENTO', 'Tipos de desplazamiento')
        ");
    }
}
