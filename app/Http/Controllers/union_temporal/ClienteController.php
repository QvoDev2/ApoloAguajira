<?php

namespace App\Http\Controllers\union_temporal;

use App\Http\Controllers\todos\ClienteController as AppClienteController;

class ClienteController extends AppClienteController
{
    public function __construct()
    {
        $this->perfil = 'union_temporal';
    }
}