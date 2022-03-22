<?php

namespace App\Http\Controllers\todos;

use App\Http\Controllers\todos\Controller;
use App\Http\Requests\todos\contrasena\UpdatePassword;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ContrasenaController extends Controller
{
    public function cambiarContrasena()
    {
        return view('todos.cambio_contrasena.form');
    }

    public function actualizarContrasena(UpdatePassword $request)
    {
        try {
            Auth::user()->update([
                'password' => Hash::make($request->password)
            ]);
            return $this->redirectSuccess(null, 'Contraseña actualizada satisfactoriamente');
        } catch (\Throwable $th) {
            return $this->redirectError();
        }
    }
}
