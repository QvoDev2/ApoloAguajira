<?php

namespace App\Http\Controllers\union_temporal;

use App\Http\Controllers\todos\EsquemaController as AppEsquemaController;

class EsquemaController extends AppEsquemaController
{
    public function __construct()
    {
        $this->perfil = 'union_temporal';
    }
}