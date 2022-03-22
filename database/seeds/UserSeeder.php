<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('TRUNCATE users');

        DB::statement('ALTER TABLE users AUTO_INCREMENT=1');

        DB::statement("
            INSERT into users (id, nombres, apellidos, documento, email, perfil_id, celular, password) VALUES
            (1, 'Admin', 'Admin', 'a', 'admin@admin.com', 1, '3014161782', '".Hash::make('z')."');
        ");

        DB::statement("
            INSERT into usuarios_zonas (usuario_id, zona_id) VALUES
            (1, 1168);
        ");
    }
}
