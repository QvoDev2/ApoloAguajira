<?php

namespace App\Http\Controllers\todos;

use App\DataTables\todos\TipoListaDataTable;
use App\Http\Controllers\todos\Controller;

class TipoListaController extends Controller
{
    public function __invoke(TipoListaDataTable $tipoListaDataTable)
    {
        return $tipoListaDataTable->render('todos.parametrizacion.tipo_listas.index');
    }
}
