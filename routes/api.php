<?php

use Illuminate\Support\Facades\Route;

//* API ROUTES
Route::namespace("api")->group(function () {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('me', 'AuthController@me');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('reset-password', 'AuthController@restablecerContrasena');
    Route::post('foto-escolta', 'AuthController@actualizarFoto');
    Route::post('actualizar-datos', 'AuthController@actualizarDatos');
    
    Route::post('historico-comisiones/{escoltaId}/{periodo}', 'ComisionController@historicoComisiones');
    Route::post('comisiones/{escoltaId}', 'ComisionController@getComisiones');
    Route::post('finalizar-comision/{comision}', 'ComisionController@finalizarComision');
    Route::get('pdf-comision/{id}', 'ComisionController@generarPDF');

    Route::post('reporte-punto/{comision}', 'PuntoControlController@storeReporte');
    Route::post('reporte-punto/foto/{reporte}', 'PuntoControlController@getFoto');
});