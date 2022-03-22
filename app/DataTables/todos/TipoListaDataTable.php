<?php

namespace App\DataTables\todos;

use App\Models\TipoLista;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class TipoListaDataTable extends DataTable
{
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);

        return $dataTable->addColumn('action', 'todos.parametrizacion.tipo_listas.datatables_actions')
        ->addColumn('cantidad', function ($row) {
            return count($row->listas);
        });
    }

    public function query(TipoLista $model)
    {
        return $model->newQuery();
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('TipoListasTable')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addAction(['title' => 'Acción', 'width' => '120px'])
            ->addTableClass('table table-striped dt-responsive')
            ->dom('lrtip')
            ->ordering(false)
            ->language(asset('DataTables/language.json'));
    }

    protected function getColumns()
    {
        return [
            'nombre',
            'descripcion' => ['title' => 'Descripción'],
            'cantidad',
        ];
    }
}
