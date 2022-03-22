<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\todos\TipoListaController as AppTipoListaController;

class TipoListaController extends AppTipoListaController
{
    public function __construct()
    {
        $this->perfil = 'admin';
    }
}
