<?php

namespace App\Http\Controllers\todos;

use App\DataTables\todos\ClienteDataTable;
use App\Http\Controllers\todos\Controller;
use App\Http\Requests\todos\clientes\CreateRequest;
use App\Http\Requests\todos\clientes\UpdateRequest;
use App\Models\Cliente;

class ClienteController extends Controller
{
    public function index(ClienteDataTable $tabla)
    {
        return $tabla->render('todos.clientes.index');
    }

    public function create()
    {
        return view('todos.clientes.create');
    }

    public function store(CreateRequest $request)
    {
        try {
            Cliente::create($request->all());
            return $this->redirectSuccess(route("{$this->perfil}.clientes.index"), 'Esquema creado satisfactoriamente');
        } catch (\Throwable $th) {
            return $this->redirectError(route("{$this->perfil}.clientes.index"));
        }
    }

    public function edit($id)
    {
        try {
            $cliente = Cliente::findOrFail($id);
            return view('todos.clientes.edit', compact('cliente'));
        } catch (\Throwable $th) {
            return $this->redirectError(route("{$this->perfil}.clientes.index"));
        }
    }

    public function update(UpdateRequest $request, $id)
    {
        try {
            Cliente::findOrFail($id)->update($request->all());
            return $this->redirectSuccess(route("{$this->perfil}.clientes.index"), 'Esquema actualizado satisfactoriamente');
        } catch (\Throwable $th) {
            return $this->redirectError(route("{$this->perfil}.clientes.index"));
        }
    }

    public function destroy($id)
    {
        try {
            Cliente::findOrFail($id)->delete();
            return $this->responseSuccess('Esquema eliminado satisfactoriamente');
        } catch (\Throwable $th) {
            return $this->responseError($th->getMessage());
        }
    }
}
