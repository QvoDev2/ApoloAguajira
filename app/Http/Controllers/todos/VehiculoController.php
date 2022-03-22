<?php

namespace App\Http\Controllers\todos;

use App\DataTables\todos\VehiculoDataTable;
use App\Http\Controllers\todos\Controller;
use App\Http\Requests\todos\vehiculos\CreateRequest;
use App\Http\Requests\todos\vehiculos\UpdateRequest;
use App\Models\Vehiculo;

class VehiculoController extends Controller
{
    public function index(VehiculoDataTable $tabla)
    {
        return $tabla->render('todos.vehiculos.index');
    }

    public function create()
    {
        return view('todos.vehiculos.create');
    }

    public function store(CreateRequest $request)
    {
        try {
            Vehiculo::create($request->all());
            return $this->redirectSuccess(route("{$this->perfil}.vehiculos.index"), 'Vehículo creado satisfactoriamente');
        } catch (\Throwable $th) {
            return $this->redirectError(route("{$this->perfil}.vehiculos.index"));
        }
    }

    public function edit($id)
    {
        try {
            $vehiculo = Vehiculo::findOrFail($id);
            return view('todos.vehiculos.edit', compact('vehiculo'));
        } catch (\Throwable $th) {
            return $this->redirectError(route("{$this->perfil}.vehiculos.index"));
        }
    }

    public function update(UpdateRequest $request, $id)
    {
        try {
            Vehiculo::findOrFail($id)
                ->update($request->all());
            return $this->redirectSuccess(route("{$this->perfil}.vehiculos.index"), 'Vehículo actualizado satisfactoriamente');
        } catch (\Throwable $th) {
            return $this->redirectError(route("{$this->perfil}.vehiculos.index"));
        }
    }

    public function destroy($id)
    {
        try {
            Vehiculo::findOrFail($id)->delete();
            return $this->responseSuccess('Vehículo eliminado satisfactoriamente');
        } catch (\Throwable $th) {
            return $this->responseError($th->getMessage());
        }
    }
}
