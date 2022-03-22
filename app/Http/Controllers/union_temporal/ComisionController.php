<?php

namespace App\Http\Controllers\union_temporal;

use App\Http\Controllers\todos\ComisionController as AppComisionController;
use App\Models\Comision;

class ComisionController extends AppComisionController
{
    public function __construct()
    {
        $this->perfil = 'union_temporal';
    }

    public function show(Comision $comisione)
    {
        try {
            return view('union_temporal.comisiones.show', compact('comisione'))->render();
        } catch (\Throwable $th) {
            return $this->responseError($th->getMessage());
        }
    }

    public function editPuntos(Comision $comision)
    {
        try {
            return view('union_temporal.comisiones.edit_puntos', compact('comision'));
        } catch (\Throwable $th) {
            return $this->redirectError(route("{$this->perfil}.comisiones.index"));
        }
    }

    public function continuar(Comision $comision)
    {
        try {
            $vista = "union_temporal.comisiones.paso{$comision->paso_creacion}";
            return view(
                view()->exists($vista) 
                ? $vista 
                : "todos.comisiones.paso{$comision->paso_creacion}", 
                compact('comision')
            );
        } catch (\Throwable $th) {
            return $this->redirectError(route("{$this->perfil}.comisiones.index"));
        }
    }
}