<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\todos\UsuarioController as AppUsuarioController;

class UsuarioController extends AppUsuarioController
{
    public function __construct()
    {
        $this->perfil = 'admin';
    }
}