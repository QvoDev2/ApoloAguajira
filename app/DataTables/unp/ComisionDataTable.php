<?php

namespace App\DataTables\unp;

use App\Models\Comision;
use App\Models\VComisionTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class ComisionDataTable extends DataTable
{
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);
        return $dataTable->addColumn('action', function ($comision) {
            return view('unp.comisiones.datatables_actions', compact('comision'));
        })
            ->addColumn('estado', function ($comision) {
                return $comision->estado_texto;
            })
            ->editColumn('cliente', function ($comision) {
                return "{$comision->cliente->nombre}<br><small>*{$comision->nombre_escolta}</small>";
            })
            ->editColumn('valor_total', function ($comision) {
                return '$' . number_format($comision->dias_reales * $comision->valor_x_dia, 0);
            })
            ->editColumn('fecha_aprobacion_correo', function ($comision) {
                return $comision->fecha_aprobacion_correo->format('d/m/Y');
            })
            ->editColumn('fecha_inicio', function ($comision) {
                return $comision->fecha_inicio->format('d/m/Y');
            })
            ->editColumn('fecha_fin', function ($comision) {
                return $comision->fecha_fin->format('d/m/Y');
            })
            ->with('contadores', function () {
                $request = $this->request();
                $contadores = VComisionTable::selectRaw('
                        estado,
                        count(1) cnt
                    ')
                    ->where(function ($q) use ($request) {
                        if ($request->escolta)
                            $q->where(function ($q2) use ($request) {
                                $q2->where('nombre_escolta', 'like', "%{$request->escolta}%")
                                    ->orWhere('identificacion_escolta', 'like', "%{$request->escolta}%");
                            });
                        if ($request->zona) $q->whereIn('zona_id', array_values($request->zona));
                        if ($request->comision) $q->where('numero', 'like', "{$request->comision}%");
                        if ($request->cliente) $q->where('cliente_id', $request->cliente);
                        if (!is_null($request->estado)) $q->where('estado', $request->estado);
                        if ($request->desde_inicio) $q->where('fecha_inicio', '>=', $request->desde_inicio);
                        if ($request->hasta_incio) $q->where('fecha_inicio', '<=', $request->hasta_incio);
                        if ($request->desde_fin) $q->where('fecha_fin', '>=', $request->desde_fin);
                        if ($request->hasta_fin) $q->where('fecha_fin', '<=', $request->hasta_fin);
                        if (!is_null($request->tipo)) $q->where('tipo', $request->tipo);
                        if (!is_null($request->novedades)) {
                            $condition = ($request->novedades == 0) ? '>' : '=';
                            $q->where('novedades', $condition, '0');
                        }
                    })
                    ->whereIn('zona_id', auth()->user()->array_zonas)
                    ->whereIn('estado', [
                        Comision::ESTADO_VERIFICADO_UT,
                        Comision::ESTADO_NOVEDAD,
                        Comision::ESTADO_APROBADO,
                        Comision::ESTADO_RECHAZADO
                    ])
                    ->groupBy('estado')
                    ->pluck('cnt', 'estado')
                    ->toArray();
                return [
                    'VERIFICADO_UT' => $contadores[Comision::ESTADO_VERIFICADO_UT] ?? 0,
                    'NOVEDAD'       => $contadores[Comision::ESTADO_NOVEDAD] ?? 0,
                    'APROBADO'      => $contadores[Comision::ESTADO_APROBADO] ?? 0,
                    'RECHAZADO'     => $contadores[Comision::ESTADO_RECHAZADO] ?? 0,
                ];
            })
            ->rawColumns(['action', 'cliente']);
    }

    public function query(VComisionTable $model)
    {
        $request = $this->request();
        return $model::where(function ($q) use ($request) {
            if ($request->escolta)
                $q->where(function ($q2) use ($request) {
                    $q2->where('nombre_escolta', 'like', "%{$request->escolta}%")
                        ->orWhere('identificacion_escolta', 'like', "%{$request->escolta}%");
                });
            if ($request->zona) $q->whereIn('zona_id', array_values($request->zona));
            if ($request->comision) $q->where('numero', 'like', "{$request->comision}%");
            if ($request->cliente) $q->where('cliente_id', $request->cliente);
            if (!is_null($request->estado)) $q->where('estado', $request->estado);
            if ($request->desde_inicio) $q->where('fecha_inicio', '>=', $request->desde_inicio);
            if ($request->hasta_incio) $q->where('fecha_inicio', '<=', $request->hasta_incio);
            if ($request->desde_fin) $q->where('fecha_fin', '>=', $request->desde_fin);
            if ($request->hasta_fin) $q->where('fecha_fin', '<=', $request->hasta_fin);
            if (!is_null($request->tipo)) $q->where('tipo', $request->tipo);
            if (!is_null($request->novedades)) {
                $condition = ($request->novedades == 0) ? '>' : '=';
                $q->where('novedades', $condition, '0');
            }
        })
            ->whereIn('zona_id', auth()->user()->array_zonas)
            ->whereIn('estado', [
                Comision::ESTADO_VERIFICADO_UT,
                Comision::ESTADO_NOVEDAD,
                Comision::ESTADO_APROBADO,
                Comision::ESTADO_RECHAZADO
            ])
            ->orderBy('created_at', 'DESC');
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('ComisionesTable')
            ->columns($this->getColumns())
            ->addTableClass('table table-striped dt-responsive')
            ->minifiedAjax()
            ->addAction(['title' => 'Acción', 'width' => '120px'])
            ->dom('lrtip')
            ->ordering(false)
            ->language(asset('DataTables/language.json'))
            ->parameters([
                'drawCallback' => 'function(data) {
                    $("#VERIFICADO_UT").html(data.json.contadores.VERIFICADO_UT)
                    $("#NOVEDAD").html(data.json.contadores.NOVEDAD)
                    $("#APROBADO").html(data.json.contadores.APROBADO)
                    $("#RECHAZADO").html(data.json.contadores.RECHAZADO)
                }'
            ]);
    }

    protected function getColumns()
    {
        return [
            'id',
            'numero'                  => ['title' => 'Cod. autorización'],
            'dias_reales'             => ['title' => 'Días legalizados'],
            'valor_total'             => ['title' => 'Valor total'],
            'cliente'                 => ['title' => 'Esquema / *Escolta'],
            'fecha_aprobacion_correo' => ['title' => 'Fecha aprobación correo'],
            'fecha_inicio'            => ['title' => 'Fecha inicio'],
            'fecha_fin'               => ['title' => 'Fecha fin'],
            'estado'
        ];
    }
}
