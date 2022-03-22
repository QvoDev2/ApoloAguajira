<?php

namespace App\Http\Controllers\todos;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Flash;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function redirectError($ruta = null, $mensaje = '')
    {
        Flash::error("Ha ocurrido un error. {$mensaje}");
        return is_null($ruta) ? redirect()->back() : redirect($ruta);
    }

    public function redirectSuccess($ruta = null, $mensaje)
    {
        Flash::success($mensaje);
        return is_null($ruta) ? redirect()->back() : redirect($ruta);
    }

    public function responseError($message)
    {
        return response($message, 500);
    }

    public function responseSuccess($message)
    {
        return response($message, 200);
    }
}