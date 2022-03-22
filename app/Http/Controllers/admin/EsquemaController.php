<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\todos\EsquemaController as AppEsquemaController;

class EsquemaController extends AppEsquemaController
{
    public function __construct()
    {
        $this->perfil = 'admin';
    }
}