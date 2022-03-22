<?php

namespace App\Http\Controllers\todos;

use App\DataTables\todos\ListaDataTable;
use App\Http\Controllers\todos\Controller;
use App\Http\Requests\todos\listas\CreateRequest;
use App\Http\Requests\todos\listas\UpdateRequest;
use App\Models\TipoLista;
use App\Models\Lista;

class ListaController extends Controller
{
    public function index(TipoLista $tipo, ListaDataTable $listaDataTable)
    {
        return $listaDataTable->render('todos.parametrizacion.listas.index', ['label' => $tipo->nombre, 'id' => $tipo->id]);
    }

    public function create(TipoLista $tipo)
    {
        return view('todos.parametrizacion.listas.create', ['id' => $tipo->id])->render();
    }

    public function store(CreateRequest $request)
    {
        try {
            Lista::create($request->all());
            return $this->responseSuccess('Lista creada satisfactoriamente');
        } catch (\Throwable $th) {
            return $this->responseError($th->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $lista = Lista::findOrFail($id);
            return view('todos.parametrizacion.listas.edit', compact('lista'))->render();
        } catch (\Throwable $th) {
            return $this->responseError($th->getMessage());
        }
    }

    public function update($id, UpdateRequest $request)
    {
        try {
            Lista::findOrFail($id)
                ->update($request->all());
            return $this->responseSuccess('Lista actualizada satisfactoriamente');
        } catch (\Throwable $th) {
            return $this->responseError($th->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            Lista::findOrFail($id)->delete();
            return $this->responseSuccess('Lista eliminada satisfactoriamente');
        } catch (\Throwable $th) {
            return $this->responseError($th->getMessage());
        }
    }
}
