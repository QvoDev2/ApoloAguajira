<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class EstadoUsuario
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
        if(Auth::user()->estado)
            return $next($request);

        Auth::logout();
        return redirect('/')->withErrors(['estado' => 'La cuenta se encuentra inactiva.']);
    }
}
