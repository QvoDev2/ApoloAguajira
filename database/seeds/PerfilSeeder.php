<?php

use Illuminate\Database\Seeder;

class PerfilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('TRUNCATE perfiles');

        DB::statement('ALTER TABLE perfiles AUTO_INCREMENT=1');

        DB::statement("
            INSERT INTO `perfiles` (`id`, `codigo`, `nombre`) VALUES
            (1, 'admin', 'Administador'),
            (2, 'ut', 'UT'),
            (3, 'unp', 'UNP'),
            (4, 'escolta', 'Escolta'),
            (5, 'union_temporal', 'Unión temporal')
        ");
    }
}
