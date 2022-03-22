<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laracasts\Flash\Flash;

class CambioClaveObligatorio
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Hash::check(Auth::user()->documento, Auth::user()->password)) {
            Flash::error('Debes actualizar tu contraseña para poder acceder a las demás funcionalidades de la aplicación.');
            return redirect(route('cambioContrasena'));
        }

        return $next($request);
    }
}
