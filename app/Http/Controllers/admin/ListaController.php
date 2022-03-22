<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\todos\ListaController as AppListaController;

class ListaController extends AppListaController
{
    public function __construct()
    {
        $this->perfil = 'admin';
    }
}
