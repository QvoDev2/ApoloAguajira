<?php

namespace App\Http\Controllers\todos;

use App\DataTables\todos\UsuarioDataTable;
use App\Http\Controllers\todos\Controller;
use App\Http\Requests\todos\usuarios\CreateRequest;
use App\Http\Requests\todos\usuarios\UpdateRequest;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UsuarioController extends Controller
{
    public function index(UsuarioDataTable $usuarioDataTable)
    {
        return $usuarioDataTable->render('todos.usuarios.index');
    }

    public function create()
    {
        return view('todos.usuarios.create');
    }

    public function store(CreateRequest $request)
    {
        try {
            $request['password'] = Hash::make($request['password']);
            DB::beginTransaction();
            User::create($request->all())->zonas()->sync($request->zonas);
            DB::commit();
            return $this->redirectSuccess(route("{$this->perfil}.usuarios.index"), 'Usuario creado satisfactoriamente');
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->redirectError(route("{$this->perfil}.usuarios.index"));
        }
    }

    public function edit($id)
    {
        try {
            $usuario = User::findOrFail($id);
            return view('todos.usuarios.edit', compact('usuario'));
        } catch (\Throwable $th) {
            return $this->redirectError(route("{$this->perfil}.usuarios.index"));
        }
    }

    public function update(UpdateRequest $request, $id)
    {
        try {
            $usuario = User::findOrFail($id);
            if (!$request['password'])
                unset($request['password']);
            else
                $request['password'] = Hash::make($request['password']);
            DB::beginTransaction();
            if ($escolta = $usuario->escolta) {
                $escolta->update([
                    'nombres'        => $request->nombre,        
                    'apellidos'      => $request->apellidos,            
                    'identificacion' => $request->documento,
                    'email'          => $request->email,
                    'celular'        => $request->celular,
                ]);
                $escolta->zonas()->sync($request->zonas);
            }
            $usuario->update($request->all());
            $usuario->zonas()->sync($request->zonas);
            DB::commit();
            return $this->redirectSuccess(route("{$this->perfil}.usuarios.index"), 'Usuario actualizado satisfactoriamente');
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->redirectError(route("{$this->perfil}.usuarios.index"), $th->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            User::findOrFail($id)->delete();
            return $this->responseSuccess(null);
        } catch (\Throwable $th) {
            return $this->responseError($th->getMessage());
        }
    }

    public function cambiarEstado($id)
    {
        try {
            $usuario = User::findOrFail($id);
            $usuario->update([
                'estado' => $usuario->estado == '1' ? '0' : '1'
            ]);
        } catch (\Throwable $th) {
            return $this->redirectError(route("{$this->perfil}.usuarios.index"));
        }
    }

    public function actualizarClave($id)
    {
        try {
            $usuario = User::findOrFail($id);
            $usuario->update([
                'password' => Hash::make("{$usuario->documento}1")
            ]);
            return $this->responseSuccess('Contraseña actualizada satisfactoriamente');
        } catch (\Throwable $th) {
            return $this->responseError($th->getMessage());
        }
    }
}