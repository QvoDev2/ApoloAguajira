<?php

namespace App\DataTables\todos;

use App\Models\Ciudad;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class CiudadDataTable extends DataTable
{
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);
        return $dataTable->addColumn('action', 'todos.parametrizacion.ciudades.datatables_actions')
            ->addColumn('departamento_id', function ($ciudad) {
                return $ciudad->departamento->nombre;
            });
    }

    public function query(Ciudad $model)
    {
        return $model->newQuery();
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('CiudadesTable')
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
            'departamento_id' => ['title' => 'Departamento'],
            'nombre',
            'longitud',
            'latitud',
            'radio'
        ];
    }
}
