<?php

namespace App\Http\Controllers\ut;

use App\Http\Controllers\todos\ClienteController as AppClienteController;

class ClienteController extends AppClienteController
{
    public function __construct()
    {
        $this->perfil = 'ut';
    }
}
