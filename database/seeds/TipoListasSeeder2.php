<?php

use Illuminate\Database\Seeder;

class TipoListasSeeder2 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('ALTER TABLE tipo_listas AUTO_INCREMENT=1');

        DB::statement("
            INSERT INTO `tipo_listas` (`id`, `codigo`, `nombre`, `descripcion`) VALUES
            (10, 'EMPRESAS',              'EMPRESAS',               'Empresas'),
            (11, 'BANCOS',                'BANCOS',                 'Bancos'),
            (12, 'TIPOS_CUENTA',          'TIPOS CUENTA',           'Tipos de cuenta')
        ");
    }
}
