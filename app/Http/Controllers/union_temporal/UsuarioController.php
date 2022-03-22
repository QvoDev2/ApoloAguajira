<?php

namespace App\Http\Controllers\union_temporal;

use App\Http\Controllers\todos\UsuarioController as AppUsuarioController;

class UsuarioController extends AppUsuarioController
{
    public function __construct()
    {
        $this->perfil = 'union_temporal';
    }
}