<?php

namespace App\DataTables\todos;

use App\Models\Escolta;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class EscoltaDataTable extends DataTable
{
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);
        return $dataTable->addColumn('action', function ($escolta) {
                return view('todos.escoltas.datatables_actions', compact('escolta'));
            })
            ->addColumn('nombre_completo', function ($escolta) {
                return $escolta->nombre_completo;
            })
            ->orderColumn('nombre_completo', function ($q, $o) {
                $q->orderBy(DB::raw('CONCAT(nombre, " ", apellidos)'), $o);
            })
            ->addColumn('tipo_escolta', function ($escolta) {
                return $escolta->tipoEscolta->nombre;
            })
            ->addColumn('tipo_contrato', function ($escolta) {
                return $escolta->tipoContrato->nombre;
            })
            ->addColumn('zonas', function ($escolta) {
                return '<ul><li>' . implode('</li><li>', $escolta->zonas()->pluck('nombre')->toArray()) . '</li></ul>';
            })
            ->addColumn('cuenta', function ($escolta) {
                return  ($escolta->banco ? $escolta->banco->nombre : "") . ($escolta->tipo_cuenta ? '-'.$escolta->tipo_cuenta->nombre : "") .' ' .$escolta->numero_cuenta ?? null;
            })
            ->editColumn('estado', function ($escolta) {
                return Escolta::ESTADOS[$escolta->estado];
            })
            ->rawColumns(['action', 'zonas']);
    }

    public function query(Escolta $model)
    {
        return $model->where(function ($q) {
                if ($tipoEscolta = $this->request()->tipo_escolta)
                    $q->where('tipo_escolta_id', $tipoEscolta);
                if ($nombre = $this->request()->nombre)
                    $q->where(DB::raw('CONCAT(nombre, " ", apellidos)'), 'like', "%{$nombre}%");
                if ($documento = $this->request()->documento)
                    $q->where('identificacion', 'like', "%{$documento}%");
                if ($zona = $this->request()->zona)
                    $q->whereHas('zonas', function ($q2) use ($zona) {
                        $q2->where('listas.id', $zona);
                    });
            })->whereHas('zonas', function ($q) {
                $q->whereIn('id', auth()->user()->array_zonas);
            });
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('EscoltasTable')
            ->columns($this->getColumns())
            ->addTableClass('table table-striped dt-responsive')
            ->minifiedAjax()
            ->addAction(['title' => 'Acción', 'width' => '120px'])
            ->dom('lrtip')
            ->ordering(true)
            ->language(asset('DataTables/language.json'));
    }

    protected function getColumns()
    {
        return [
            'id',
            'tipo_escolta'    => ['title' => 'Tipo escolta', 'orderable' => false],
            'tipo_contrato'   => ['title' => 'Tipo contrato', 'orderable' => false],
            'nombre_completo' => ['title' => 'Nombre'],
            'identificacion',
            'zonas'           => ['orderable' => false],
            'cuenta'           => ['orderable' => false],
            'estado'
        ];
    }
}
