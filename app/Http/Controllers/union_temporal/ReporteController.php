<?php

namespace App\Http\Controllers\union_temporal;

use App\Http\Controllers\todos\ReporteController as AppReporteController;

class ReporteController extends AppReporteController
{
    public function __construct()
    {
        $this->perfil = 'union_temporal';
    }
}