<?php

namespace App\DataTables\todos;

use App\Models\Pago;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class PagoDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);

        return $dataTable->addColumn('action', 'todos.pagos.datatables_actions')
            ->addColumn('fecha_pago', function ($pago) {
                return (!empty($pago->fecha_pago)) ? $pago->fecha_pago->format('d/m/Y') : '';
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models/Pago $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        // dd($this->request()
        // ->comision
        // ->pagos()->get());
        return $this->request()
            ->comision
            ->pagos()
            ->orderByDesc('created_at');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('PagoTable')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addAction(['title' => 'Acción', 'width' => '120px'])
            ->addTableClass('table table-striped dt-responsive')
            ->ordering(false)
            ->language(asset('DataTables/language.json'));
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'valor',
            'codigo',
            'fecha_pago',
            'observaciones',
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'contratos/Pago_' . date('YmdHis');
    }
}
