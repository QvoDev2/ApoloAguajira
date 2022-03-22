<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\todos\EscoltaController as AppEscoltaController;

class EscoltaController extends AppEscoltaController
{
    public function __construct()
    {
        $this->perfil = 'admin';
    }
}