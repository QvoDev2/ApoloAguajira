<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\todos\ComisionController as AppComisionController;

class ComisionController extends AppComisionController
{
    public function __construct()
    {
        $this->perfil = 'admin';
    }
}