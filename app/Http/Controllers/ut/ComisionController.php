<?php

namespace App\Http\Controllers\ut;

use App\Http\Controllers\todos\ComisionController as AppComisionController;

class ComisionController extends AppComisionController
{
    public function __construct()
    {
        $this->perfil = 'ut';
    }
}