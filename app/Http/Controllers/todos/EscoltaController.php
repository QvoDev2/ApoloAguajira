<?php

namespace App\Http\Controllers\todos;

use App\DataTables\todos\EscoltaDataTable;
use App\Http\Controllers\todos\Controller;
use App\Http\Requests\todos\escoltas\CreateRequest;
use App\Http\Requests\todos\escoltas\UpdateRequest;
use App\Models\Escolta;
use Illuminate\Support\Facades\DB;

class EscoltaController extends Controller
{
    public function index(EscoltaDataTable $tabla)
    {
        return $tabla->render('todos.escoltas.index');
    }

    public function create()
    {
        return view('todos.escoltas.create');
    }

    public function store(CreateRequest $request)
    {
        try {
            DB::beginTransaction();
            $escolta = Escolta::create($request->all());
            $escolta->zonas()->sync($request->zonas);
            $escolta->cargarFoto($request->file('imagen'));
            if ($request->usuario)
                $escolta->crearUsuario($request);
            DB::commit();
            return $this->redirectSuccess(route("{$this->perfil}.escoltas.index"), 'Escolta creado satisfactoriamente');
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->redirectError(route("{$this->perfil}.escoltas.index"), $th->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $escolta = Escolta::findOrFail($id);
            return view('todos.escoltas.edit', compact('escolta'));
        } catch (\Throwable $th) {
            return $this->redirectError(route("{$this->perfil}.escoltas.index"));
        }
    }

    public function update(UpdateRequest $request, $id)
    {
        try {
            $escolta = Escolta::findOrFail($id);
            DB::beginTransaction();
            $escolta->update($request->all());
            $escolta->zonas()->sync($request->zonas);
            if ($usuario = $escolta->usuario) {
                $usuario->update([
                    'nombres'   => $request->nombre,
                    'apellidos' => $request->apellidos,
                    'documento' => $request->identificacion,
                    'email'     => $request->email,
                    'celular'   => $request->celular,
                ]);
                $usuario->zonas()->sync($request->zonas);
            }
            if ($foto = $request->file('imagen'))
                $escolta->cargarFoto($foto, true);
            DB::commit();
            return $this->redirectSuccess(route("{$this->perfil}.escoltas.index"), 'Escolta actualizado satisfactoriamente');
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->redirectError(route("{$this->perfil}.escoltas.index"));
        }
    }

    public function destroy($id)
    {
        try {
            Escolta::findOrFail($id)->delete();
            return $this->responseSuccess('Escolta eliminado satisfactoriamente');
        } catch (\Throwable $th) {
            return $this->responseError($th->getMessage());
        }
    }
}
