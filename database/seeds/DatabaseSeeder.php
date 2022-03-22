<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        $this->call(PerfilSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(TipoListaSeeder::class);
        $this->call(ListaSeeder::class);
        $this->call(TipoDesplazamiento::class);
        $this->call(TipoListasSeeder2::class);
        $this->call(ListasSeeder2::class);
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
