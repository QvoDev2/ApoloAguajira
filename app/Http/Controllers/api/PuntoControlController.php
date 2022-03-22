<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\todos\Controller;
use App\Models\Comision;
use App\Models\ReportePunto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class PuntoControlController extends Controller 
{
    public function __construct()
    {
        $this->middleware('jwt');
        $this->auth = auth()->guard('api');
    }

    public function storeReporte(Comision $comision, Request $request)
    {
        try {
            $campos = ['observaciones', 'ubicacion'];
            foreach ($campos as $campo) 
                $request[$campo] = base64_decode($request[$campo]);
            DB::beginTransaction();
            $reporte = $comision->reportes()->create($request->all());
            $request->file('imagen1')->store("reportes_puntos/{$reporte->id}", 'public');
            for ($i = 2; $i <= 4; $i++) 
                if ($archivo = $request->file("imagen{$i}"))
                    $archivo->store("reportes_puntos/{$reporte->id}/novedades", 'public');
            if ($request->punto_control_id)
                $comision->validarEstado($request);
            DB::commit();
            return response()->json(['response' => 'Reporte registrado exitosamente']);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(['error' => ['mensaje' => $th->getMessage()]]);
        }
    }

    public function getFoto(ReportePunto $reporte)
    {
        return Response::download(public_path($reporte->ruta_foto));
    }
}