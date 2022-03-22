<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\todos\CiudadController as AppCiudadController;

class CiudadController extends AppCiudadController
{
    public function __construct()
    {
        $this->perfil = 'admin';
    }
}
