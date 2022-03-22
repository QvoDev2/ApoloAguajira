<?php

namespace App\DataTables\todos;

use App\Models\Lista;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class ListaDataTable extends DataTable
{
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);

        return $dataTable->addColumn('action', 'todos.parametrizacion.listas.datatables_actions')
            ->editColumn('nombre', function ($lista) {
                if ($lista->tipo_lista_id == 7)
                    return $lista->codigo ? '$'.number_format($lista->codigo, 0)." - {$lista->nombre}" : $lista->nombre;
                else
                    return $lista->codigo ? "{$lista->codigo} - {$lista->nombre}" : $lista->nombre;
            })
            ->addColumn('padre', function ($lista) {
                return $lista->padre->nombre ?? '';
            })
            ->addColumn('descripcion', function ($lista) {
                return nl2br($lista->descripcion);
            })
            ->rawColumns(['action', 'descripcion']);
    }

    public function query(Lista $model)
    {
        return $model::where('tipo_lista_id', $this->request()->tipo->id);
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('listasTable')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addAction(['title' => 'Acción', 'width' => '120px'])
            ->addTableClass('table table-striped dt-responsive')
            ->ordering(false)
            ->language(asset('DataTables/language.json'));
    }

    protected function getColumns()
    {
        return [
            'nombre',
            'descripcion' => ['title' => 'Descripción'],
            'padre'       => ['title' => 'Pertenece a']
        ];
    }
}
