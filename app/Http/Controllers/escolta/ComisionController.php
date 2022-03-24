<?php

namespace App\Http\Controllers\escolta;

use App\Http\Controllers\todos\ComisionController as AppComisionController;

class ComisionController extends AppComisionController
{
    public function __construct()
    {
        $this->perfil = 'escolta';
    }
}
