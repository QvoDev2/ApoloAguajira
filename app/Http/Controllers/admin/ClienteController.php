<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\todos\ClienteController as AppClienteController;

class ClienteController extends AppClienteController
{
    public function __construct()
    {
        $this->perfil = 'admin';
    }
}