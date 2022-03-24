<?php

namespace App\Http\Controllers\ut;

use App\Http\Controllers\admin\PagoController as AppPagoController;

class PagoController extends AppPagoController
{
    public function __construct()
    {
        $this->perfil = 'ut';
    }
}
