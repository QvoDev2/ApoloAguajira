<?php

namespace App\DataTables\todos;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class UsuarioDataTable extends DataTable
{
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);
        return $dataTable->addColumn('action', 'todos.usuarios.datatables_actions')
            ->addColumn('nombre', function ($usuario) {
                return "{$usuario->nombres} {$usuario->apellidos}";
            })
            ->addColumn('estado', function ($usuario) {
                return $usuario->estado ? 'Activo' : 'Inactivo';
            })
            ->addColumn('perfil', function ($usuario) {
                return $usuario->perfil->nombre;
            })
            ->addColumn('zonas', function ($usuario) {
                return '<ul><li>' . implode('</li><li>', $usuario->zonas()->pluck('nombre')->toArray()) . '</li></ul>';
            })
            ->rawColumns(['action', 'zonas']);
    }

    public function query(User $model)
    {
        return $model->where(function ($q) {
                if ($perfil = $this->request()->perfil)
                    $q->where('perfil_id', $perfil);
                if ($nombre = $this->request()->nombre)
                    $q->where(DB::raw('CONCAT(nombres, " ", apellidos)'), 'like', "%{$nombre}%");
                if ($documento = $this->request()->documento)
                    $q->where('documento', 'like', "%{$documento}%");
            })->whereHas('zonas', function ($q) {
                $q->whereIn('id', auth()->user()->array_zonas);
            });
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('UsuariosTable')
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
            'nombre' => ['title' => 'Nombre completo'],
            'documento',
            'email' => ['title' => 'Correo electrónico'],
            'celular',
            'perfil',
            'zonas',
            'estado'
        ];
    }
}
