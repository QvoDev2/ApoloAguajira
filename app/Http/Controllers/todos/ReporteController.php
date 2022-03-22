<?php

namespace App\Http\Controllers\todos;

use App\Http\Controllers\todos\Controller;
use App\Http\Requests\todos\reportes\AsignacionRequest;
use App\Models\ReportePunto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{
    public function asignar(ReportePunto $reporte)
    {
        return view('todos.comisiones.reportes.asignar', compact('reporte'))->render();
    }

    public function show(ReportePunto $reporte)
    {
        return view('todos.comisiones.validacion', compact('reporte'))->render();
    }

    public function aprobar(ReportePunto $reporte)
    {
        try {
            $reporte->update([
                'estado' => 'Aprobado'
            ]);
            return $this->responseSuccess('Proceso exitoso');
        } catch (\Throwable $th) {
            return $this->responseError($th->getMessage());
        }
    }

    public function rechazar(ReportePunto $reporte, Request $request)
    {
        try {
            $reporte->update([
                'estado'                => 'Rechazado',
                'observaciones_rechazo' => $request->observaciones
            ]);
            return $this->responseSuccess('Proceso exitoso');
        } catch (\Throwable $th) {
            return $this->responseError($th->getMessage());
        }
    }

    public function guardarAsignacion(ReportePunto $reporte, AsignacionRequest $request)
    {
        try {
            DB::beginTransaction();
            $reporte->update($request->all() + [
                'usuario_asigna_id' => auth()->user()->id
            ]);
            $reporte->comision->recalcularFechas();
            DB::commit();
            return $this->responseSuccess('Se realizó la asignación satisfactoriamente');
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->responseError($th->getMessage());
        }
    }
}
