<?php

namespace App\Http\Controllers\todos;

use App\Http\Controllers\todos\Controller;
use App\Http\Requests\todos\esquemas_seguridad\UpdateRequest;
use App\Models\Cliente;
use App\Models\Escolta;
use Illuminate\Http\Request;

class EsquemaController extends Controller
{
    public function index($clienteId)
    {
        try {
            $cliente = Cliente::findOrFail($clienteId);
            return view('todos.clientes.esquemas_seguridad.index', compact('cliente'))->render();
        } catch (\Throwable $th) {
            return $this->responseError($th->getMessage());
        }
    }

    public function getEscoltasDisponibles($clienteId, Request $request)
    {
        try {
            $cliente = Cliente::findOrFail($clienteId);
            $esoltasDisponibles = $cliente->escoltas_disponibles_query
                ->whereNotIn('id', $request->escoltas ?? [])
                ->where(function ($q) use ($request) {
                    $q->where('nombre', 'like', "%{$request->filtro}%")
                        ->orWhere('identificacion', 'like', "%{$request->filtro}%");
                })->limit(5)->get();
            return view('todos.clientes.esquemas_seguridad.escoltas_disponibles', compact('esoltasDisponibles'))->render();
        } catch (\Throwable $th) {
            return $this->responseError($th->getMessage());
        }
    }

    public function update($clienteId, UpdateRequest $request)
    {
        try {
            $cliente = Cliente::findOrFail($clienteId);
            $escoltas = [];
            foreach ($request->escoltas ?? [] as $escolta)
                $escoltas[$escolta['id']] = [
                    'fecha_vinculacion' => $escolta['vinculacion'],
                    'fecha_retiro' => $escolta['retiro']
                ];
            $cliente->escoltas()->sync($escoltas);
            return $this->responseSuccess('Esquema de seguridad actualizado correctamente');
        } catch (\Throwable $th) {
            return $this->responseError($th->getMessage());
        }
    }
}
