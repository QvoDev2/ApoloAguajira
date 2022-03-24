<?php

namespace App\Http\Controllers\unp;

use App\Http\Controllers\todos\ReporteController as AppReporteController;
use App\Models\ReportePunto;

class ReporteController extends AppReporteController
{
    public function __construct()
    {
        $this->perfil = 'unp';
    }

    public function show(ReportePunto $reporte)
    {
        return view('unp.comisiones.validacion', compact('reporte'))->render();
    }
}
