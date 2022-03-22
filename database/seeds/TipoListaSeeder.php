<?php

use Illuminate\Database\Seeder;

class TipoListaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('TRUNCATE tipo_listas');

        DB::statement('ALTER TABLE tipo_listas AUTO_INCREMENT=1');

        DB::statement("
            INSERT INTO `tipo_listas` (`id`, `codigo`, `nombre`, `descripcion`) VALUES
            (1, 'TIPOS_ESCOLTA',          'TIPOS ESCOLTA',          'Tipos de escolta'),
            (2, 'TIPOS_CONTRATO_ESCOLTA', 'TIPOS CONTRATO ESCOLTA', 'Tipos de contrato para los escoltas'),
            (3, 'TIPOS_VEHICULO',         'TIPOS VEHÍCULO',         'Tipos de vehículo'),
            (5, 'DEPARTAMENTOS',          'DEPARTAMENTOS',          'Departamentos'),
            (6, 'CIUDADES',               'CIUDADES',               'Ciudades'),
            (7, 'ZONAS',                  'ZONAS',                  'Zonas')
        ");
    }
}
