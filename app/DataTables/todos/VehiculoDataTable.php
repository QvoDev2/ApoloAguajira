<?php

namespace App\DataTables\todos;

use App\Models\Vehiculo;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class VehiculoDataTable extends DataTable
{
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);
        return $dataTable->addColumn('action', 'todos.vehiculos.datatables_actions')
            ->addColumn('tipo', function ($vehiculo) {
                return $vehiculo->tipo->nombre;
            });
    }

    public function query(Vehiculo $model)
    {
        return $model->newQuery();
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('VehiculosTable')
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
            'tipo',
            'placa',
            'modelo',
            'marca'
        ];
    }
}
