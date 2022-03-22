<?php

namespace App\Http\Controllers\union_temporal;

use App\Http\Controllers\todos\EscoltaController as AppEscoltaController;

class EscoltaController extends AppEscoltaController
{
    public function __construct()
    {
        $this->perfil = 'union_temporal';
    }
}