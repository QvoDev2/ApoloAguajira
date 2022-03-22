<?php

namespace App\DataTables\todos;

use App\Models\Cliente;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class ClienteDataTable extends DataTable
{
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);
        return $dataTable->addColumn('action', 'todos.clientes.datatables_actions')
            ->addColumn('zona_id', function ($cliente) {
                return $cliente->zona->nombre;
            })
            ->addColumn('ciudad_id', function ($cliente) {
                return $cliente->ciudad->nombre ?? '';
            });
    }

    public function query(Cliente $model)
    {
        return $model->where(function ($q) {
            if ($nombre = $this->request()->nombre)
                $q->where('nombre', 'like', "%{$nombre}%");
            if ($zona = $this->request()->zona)
                $q->where('zona_id', $zona);
        })->whereIn('zona_id', auth()->user()->array_zonas);
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('ClientesTable')
            ->columns($this->getColumns())
            ->addTableClass('table table-striped dt-responsive')
            ->minifiedAjax()
            ->addAction(['title' => 'Acción', 'width' => '120px'])
            ->dom('lrtip')
            ->ordering(false)
            ->language(asset('DataTables/language.json'));
    }

    protected function getColumns()
    {
        return [
            'id',
            'nombre',
            'zona_id'   => ['title' => 'Zona'],
            'ciudad_id' => ['title' => 'Origen'],
        ];
    }
}