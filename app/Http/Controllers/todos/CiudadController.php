<?php

namespace App\Http\Controllers\todos;

use App\DataTables\todos\CiudadDataTable;
use App\Http\Controllers\todos\Controller;
use App\Http\Requests\todos\ciudades\CreateRequest;
use App\Http\Requests\todos\ciudades\UpdateRequest;
use App\Models\Ciudad;
use Illuminate\Http\Request;

class CiudadController extends Controller
{
    public function index(CiudadDataTable $tabla)
    {
        return $tabla->render('todos.parametrizacion.ciudades.index');
    }

    public function create()
    {
        return view('todos.parametrizacion.ciudades.create');
    }

    public function store(CreateRequest $request)
    {
        try {
            Ciudad::create($request->all());
            return $this->redirectSuccess(route("{$this->perfil}.ciudades.index"), 'Ciudad creada satisfactoriamente');
        } catch (\Throwable $th) {
            return $this->redirectError(route("{$this->perfil}.ciudades.index"));
        }
    }

    public function edit($id)
    {
        try {
            $ciudad = Ciudad::findOrFail($id);
            return view('todos.parametrizacion.ciudades.edit', compact('ciudad'));
        } catch (\Throwable $th) {
            return $this->redirectError(route("{$this->perfil}.ciudades.index"));
        }
    }

    public function update(UpdateRequest $request, $id)
    {
        try {
            Ciudad::findOrFail($id)
                ->update($request->all());
            return $this->redirectSuccess(route("{$this->perfil}.ciudades.index"), 'Ciudad actualizada satisfactoriamente');
        } catch (\Throwable $th) {
            return $this->redirectError(route("{$this->perfil}.ciudades.index"));
        }
    }

    public function destroy($id)
    {
        try {
            Ciudad::findOrFail($id)->delete();
            return $this->responseSuccess('Ciudad eliminada satisfactoriamente');
        } catch (\Throwable $th) {
            return $this->responseError($th->getMessage());
        }
    }
}
