<?php

namespace App\Http\Controllers\ut;

use App\Http\Controllers\todos\EsquemaController as AppEsquemaController;

class EsquemaController extends AppEsquemaController
{
    public function __construct()
    {
        $this->perfil = 'ut';
    }
}