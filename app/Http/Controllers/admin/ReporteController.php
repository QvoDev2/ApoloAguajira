<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\todos\ReporteController as AppReporteController;

class ReporteController extends AppReporteController
{
    public function __construct()
    {
        $this->perfil = 'admin';
    }
}