<?php

namespace App\Http\Controllers\unp;

use App\DataTables\unp\ComisionDataTable;
use App\Exports\unp\ComisionesExport;
use App\Http\Controllers\todos\ComisionController as AppComisionController;
use App\Models\Comision;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ComisionController extends AppComisionController
{
    public function __construct()
    {
        $this->perfil = 'unp';
    }

    public function indexUnp(ComisionDataTable $tabla)
    {
        return $tabla->render('unp.comisiones.index');
    }

    public function exportar(Request $request)
    {
        return Excel::download(new ComisionesExport($request), 'Comisiones.xlsx');
    }

    public function show(Comision $comisione)
    {
        try {
            return view('unp.comisiones.show', compact('comisione'))->render();
        } catch (\Throwable $th) {
            return $this->responseError($th->getMessage());
        }
    }
}