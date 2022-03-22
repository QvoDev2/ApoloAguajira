<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\todos\Controller;
use App\Models\Comision;
use App\Models\Escolta;
use Carbon\Carbon;
use PDF;
use Illuminate\Http\Request;

class ComisionController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt');
        $this->auth = auth()->guard('api');
    }

    public function getComisiones($escoltaId, Request $request)
    {
        try {
            if (!($escolta = Escolta::find($escoltaId)))
                return response()->json(['error' => 'El escolta no se encuentra registrado en el sistema']);

            if (!empty($request->get('mock_location')) && $request->get('mock_location') == 'S') {
                $escolta->mock_location = 'S';
                $escolta->save();
            }
            return response()->json([
                'response' => [
                    'comisiones' => $escolta->comisiones()
                        ->selectRaw('
                            comisiones.*,
                            vehiculos_escoltas.escolta_id,
                            (SELECT estado FROM estados_comisiones WHERE comisiones.id = estados_comisiones.comision_id ORDER BY created_at DESC LIMIT 1) estado,
                            (SELECT count(1) FROM reportes_puntos_control WHERE comisiones.id = reportes_puntos_control.comision_id AND punto_control_id IS NULL) cantidad_novedades
                        ')
                        ->havingRaw('estado IN (' . Comision::ESTADO_ASIGNADO . ', ' . Comision::ESTADO_EN_CURSO . ')')
                        ->with([
                            'puntosControl' => function ($q) {
                                $q->selectRaw('
                                    puntos_control.*,
                                    (SELECT nombre FROM listas WHERE listas.id = puntos_control.departamento_id) departamento_nombre,
                                    IF(EXISTS(SELECT 1 FROM reportes_puntos_control WHERE puntos_control.id = reportes_puntos_control.punto_control_id), "S", "N") reportado,
                                    (SELECT count(1) FROM reportes_puntos_control WHERE puntos_control.id = reportes_puntos_control.punto_control_id) cantidad_reportes
                                ');
                            }
                        ])
                        ->get()
                ]
            ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => ['mensaje' => $th->getMessage()]]);
        }
    }

    public function finalizarComision(Comision $comision)
    {
        try {
            if (!$comision->existeEstado(Comision::ESTADO_FINALIZADO)) {
                $estado = $comision->estados()->create([
                    'observaciones' => '',
                    'estado'        => Comision::ESTADO_FINALIZADO,
                    'usuario_id'    => auth()->user()->id
                ]);
                $estado->created_at = $comision->getFechaReporte('max');
                $estado->update();
            }
            return response()->json(['response' => 'Comisión finalizada exitosamente']);
        } catch (\Throwable $th) {
            return response()->json(['error' => ['mensaje' => $th->getMessage()]]);
        }
    }

    public function historicoComisiones($escoltaId, $periodo)
    {
        try {
            if (!($escolta = Escolta::find($escoltaId)))
                return response()->json(['error' => 'El escolta no se encuentra registrado en el sistema']);
            return response()->json([
                'response' => [
                    'comisiones' => $escolta->comisiones()
                        ->selectRaw('
                            comisiones.*,
                            CASE (SELECT estado FROM estados_comisiones WHERE comisiones.id = estados_comisiones.comision_id ORDER BY created_at DESC LIMIT 1) 
                            WHEN 0 THEN "SIN COMPLETAR"
                            WHEN 1 THEN "ASIGNADO"
                            WHEN 2 THEN "EN CURSO"
                            WHEN 3 THEN "CANCELADO"
                            WHEN 4 THEN "FINALIZADO"
                            WHEN 5 THEN "VERIFICADO UT"
                            WHEN 6 THEN "NOVEDAD"
                            WHEN 7 THEN "APROBADO UNP"
                            WHEN 8 THEN "RECHAZADO UNP"
                            WHEN 9 THEN "SOLO DESPLAZAMIENTO"
                            END estado_texto
                        ')
                        ->having('estado_texto', '<>', Comision::ESTADOS[Comision::SOLO_DESPLAZAMIENTO])
                        ->whereRaw("date_format(fecha_inicio, '%Y%m') = '{$periodo}'")
                        ->with([
                            'reportes' => function ($q) {
                                $q
                                    ->selectRaw('
                                    reportes_puntos_control.id,
                                    (SELECT nombre FROM listas WHERE id = (SELECT departamento_id FROM puntos_control WHERE id = reportes_puntos_control.punto_control_id)) departamento,
                                    (SELECT lugar FROM puntos_control WHERE id = reportes_puntos_control.punto_control_id) lugar,
                                    (SELECT longitud FROM puntos_control WHERE id = reportes_puntos_control.punto_control_id) longitud_punto,
                                    (SELECT latitud FROM puntos_control WHERE id = reportes_puntos_control.punto_control_id) latitud_punto,
                                    (SELECT radio FROM puntos_control WHERE id = reportes_puntos_control.punto_control_id) radio_punto,
                                    reportes_puntos_control.longitud longitud_reportada,
                                    reportes_puntos_control.latitud latitud_reportada,
                                    reportes_puntos_control.fecha_reporte fecha,
                                    reportes_puntos_control.*
                                ')
                                    ->whereHas('punto');
                            }
                        ])
                        ->get()
                ]
            ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => ['mensaje' => $th->getMessage()]]);
        }
    }

    public function generarPDF($id)
    {
        try {
            $comision = Comision::find($id);
            $observacionesUNP = "";
            $currentTime = Carbon::now();
            $currentDate = $currentTime->toDateTimeString();
            foreach ($comision->estados as $estado) {
                if ($estado->estado == 7) {
                    $observacionesUNP = $estado->observaciones;
                    break;
                }
            }
            $pdf = PDF::loadView('soportes.pdf_comision', compact(['comision', 'observacionesUNP', 'currentDate']));
            return $pdf->download('soporte.pdf', 'pdf_comision.pdf', ['Content-Type: application/pdf']);
        } catch (\Throwable $th) {
            return response()->json(['error' => ['mensaje' => $th->getMessage()]]);
        }
    }
}
