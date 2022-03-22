<?php

namespace App\Http\Controllers\ut;

use App\Http\Controllers\todos\UsuarioController as AppUsuarioController;

class UsuarioController extends AppUsuarioController
{
    public function __construct()
    {
        $this->perfil = 'ut';
    }
}