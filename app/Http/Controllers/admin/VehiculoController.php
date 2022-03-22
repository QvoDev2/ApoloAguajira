<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\todos\VehiculoController as AppVehiculoController;

class VehiculoController extends AppVehiculoController
{
    public function __construct()
    {
        $this->perfil = 'admin';
    }
}