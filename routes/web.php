<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Route::get('/actualizar', function () {
//     DB::beginTransaction();
//     User::where('perfil_id', 4)
//     ->where('created_at', '>', '2021-08-17 12:52:48')
//     ->each(function (User $user) {
//         $user->update(['password' => Hash::make($user->documento.'1')]);
//     });
//     DB::commit();
//     return 'Breve';
// });

//* LOGIN
Route::get('/', function () {
    Auth::logout();
    return view('auth.login');
});

//* AUTH ROUTES
Auth::routes([
    'register' => false,
    'confirm' => false
]);

Route::group(['middleware' => ['auth', 'estado', 'variables']], function () {
    //* ACTUALIZAR CONTRASEÑA
    Route::group(['namespace' => 'todos'], function () {
        Route::get('contrasena', 'ContrasenaController@cambiarContrasena')->name('cambioContrasena');
        Route::patch('contrasena', 'ContrasenaController@actualizarContrasena')->name('actualizarContrasena');
    });

    //* SÓLO PERMITE EL ACCESO SI LA CONTRASEÑA ES DIFERENTE DEL DOCUMENTO
    Route::group(['middleware' => 'clave'], function () {
        //* HOME
        Route::get('home', function () {
            return view(auth()->user()->perfil->codigo . '.layouts.home');
        })->name('home');

        //! RUTAS ADMINISTRADOR
        Route::group(['middleware' => 'role_check:admin', 'prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'admin'], function () {
            //* USUARIOS
            Route::patch('usuarios/cambiar-estado/{id}', 'UsuarioController@cambiarEstado')->name('usuarios.cambiar-estado');
            Route::patch('usuarios/actualiza-clave/{id}', 'UsuarioController@actualizarClave')->name('usuarios.actualizarClave');
            Route::resource('usuarios', 'UsuarioController')->except(['show']);

            //* COMISIONES
            Route::get('comisiones/coordenadas', 'ComisionController@getCoordenadas')->name('comisiones.getCoordenadas');
            Route::get('comisiones/consultar-escoltas/{clienteId}', 'ComisionController@getEscoltasDisponibles')->name('comisiones.getEscoltasDisponibles');
            Route::get('comisiones/consultar-escoltas/{clienteId}', 'ComisionController@getEscoltasDisponibles')->name('comisiones.getEscoltasDisponibles');
            Route::get('comisiones/continuar/{comision}', 'ComisionController@continuar')->name('comisiones.continuar');
            Route::get('comisiones/novedades/{comision}', 'ComisionController@getNovedades')->name('comisiones.getNovedades');
            Route::get('comisiones/json/{comision}', 'ComisionController@getComision')->name('comisiones.getComision');
            Route::get('comisiones/edit-puntos/{comision}', 'ComisionController@editPuntos')->name('comisiones.editPuntos');
            Route::get('comisiones/exportar', 'ComisionController@exportar')->name('comisiones.exportar');
            Route::post('comisiones/procesar/{comision}', 'ComisionController@procesar')->name('comisiones.procesar');
            Route::post('comisiones/verificar/{comision}', 'ComisionController@verificar')->name('comisiones.verificar');
            Route::post('comisiones/rechazar/{comision}', 'ComisionController@rechazar')->name('comisiones.rechazar');
            Route::post('comisiones/guardar-escoltas/{comision}', 'ComisionController@storeEscoltas')->name('comisiones.storeEscoltas');
            Route::post('comisiones/guardar-vehiculos/{comision}', 'ComisionController@storeVehiculos')->name('comisiones.storeVehiculos');
            Route::post('comisiones/guardar-puntos/{comision}', 'ComisionController@storePuntos')->name('comisiones.storePuntos');
            Route::patch('comisiones/finalizar/{comision}', 'ComisionController@finalizar')->name('comisiones.finalizar');
            Route::patch('comisiones/reiniciar/{comision}', 'ComisionController@reiniciar')->name('comisiones.reiniciar');
            Route::patch('comisiones/actualizar-puntos/{comision}', 'ComisionController@updatePuntos')->name('comisiones.updatePuntos');
            Route::get('comisiones/descargar-plantilla-excel', 'ComisionController@descargarPlantillaExcel')->name('comisiones.descargarPlantillaExcel');
            Route::post('comisiones/importar-plantilla-excel', 'ComisionController@importar')->name('comisiones.importar');
            Route::get('comisiones/ultima-importacion', 'ComisionController@ultimaImportacion')->name('comisiones.ultimaImportacion');
            Route::post('comisiones/guardar-puntos-import/{comision}', 'ComisionController@storePuntosImport')->name('comisiones.storePuntosImport');
            Route::resource('comisiones', 'ComisionController');
            Route::group(['prefix' => 'comisiones'], function () {
                //* REPORTES
                Route::get('reportes/asignar/{reporte}', 'ReporteController@asignar')->name('reportes.asignar');
                Route::get('reportes/{reporte}', 'ReporteController@show')->name('reportes.show');
                Route::post('reportes/asignar/{reporte}', 'ReporteController@guardarAsignacion')->name('reportes.guardarAsignacion');
                Route::post('reportes/aprobar/{reporte}', 'ReporteController@aprobar')->name('reportes.aprobar');
                Route::post('reportes/rechazar/{reporte}', 'ReporteController@rechazar')->name('reportes.rechazar');
            });
            //* ESCOLTAS
            Route::match(['patch','post'],'escoltas/importar','EscoltaController@importar')->name('escoltas.importar');
            Route::resource('escoltas', 'EscoltaController')->except(['show']);

            //* CLIENTES
            Route::resource('clientes', 'ClienteController')->except(['show']);
            Route::group(['prefix' => 'clientes'], function () {
                Route::get('esquema-seguridad/{clienteId}', 'EsquemaController@index')->name('esquema.index');
                Route::get('esquema-seguridad/consultar/escoltas-disponibles/{clienteId}', 'EsquemaController@getEscoltasDisponibles')->name('esquema.getEscoltasDisponibles');
                Route::post('esquema-seguridad/{clienteId}', 'EsquemaController@update')->name('esquema.update');
            });

            //* PARAMETRIZACIÓN
            Route::group(['prefix' => 'parametrizacion'], function () {
                //* TIPO LISTAS
                Route::get('tipo-listas', 'TipoListaController')->name('tipoListas.index');

                //* LISTAS
                Route::get('listas/{tipo}', 'ListaController@index')->name('listas.index');
                Route::get('listas/create/{tipo}', 'ListaController@create')->name('listas.create');
                Route::resource('listas', 'ListaController')->except(['index', 'show', 'create']);

                //* VEHÍCULOS
                Route::resource('vehiculos', 'VehiculoController')->except(['show']);

                //* CIUDADES
                Route::resource('ciudades', 'CiudadController');
            });

            //* PAGOS
            Route::get('pagos/{comision}', 'PagoController@index')->name('pagos.index');
            Route::get('pagos/create/{comision}', 'PagoController@create')->name('pagos.create');
            Route::post('pagos/{comisionId}', 'PagoController@store')->name('pagos.store');
            Route::get('pagos/{comisionId}/edit', 'PagoController@edit')->name('pagos.edit');
            Route::patch('pago/{pagoId}', 'PagoController@update')->name('pagos.update');
            Route::delete('pagos/{pagoId}', 'PagoController@destroy')->name('pagos.destroy');
            Route::get('pagos/download-file/{pagoId}', 'PagoController@downloadFile')->name('pagos.downloadFile');

            //* DEVOLUCIONES
            Route::get('devoluciones/create/{contrato}', 'DevolucionController@create')->name('devoluciones.create');
            Route::post('devoluciones/{comisionId}', 'DevolucionController@store')->name('devoluciones.store');
            Route::get('devoluciones/{comisionId}/edit', 'DevolucionController@edit')->name('devoluciones.edit');
            Route::patch('devoluciones/{devolucionId}', 'DevolucionController@update')->name('devoluciones.update');
            Route::delete('devoluciones/{devolucionId}', 'DevolucionController@destroy')->name('devoluciones.destroy');
            Route::get('devoluciones/get-datos/{comisionId}', 'DevolucionController@getDatos')->name('devoluciones.getDatos');
            Route::get('devoluciones/download-file/{devolucionId}', 'DevolucionController@downloadFile')->name('devoluciones.downloadFile');
        });

        //! RUTAS UT
        Route::group(['middleware' => 'role_check:ut', 'prefix' => 'ut', 'as' => 'ut.', 'namespace' => 'ut'], function () {
            //* USUARIOS
            Route::patch('usuarios/actualiza-clave/{id}', 'UsuarioController@actualizarClave')->name('usuarios.actualizarClave');

            //* COMISIONES
            Route::get('comisiones/coordenadas', 'ComisionController@getCoordenadas')->name('comisiones.getCoordenadas');
            Route::get('comisiones/consultar-escoltas/{clienteId}', 'ComisionController@getEscoltasDisponibles')->name('comisiones.getEscoltasDisponibles');
            Route::get('comisiones/continuar/{comision}', 'ComisionController@continuar')->name('comisiones.continuar');
            Route::get('comisiones/novedades/{comision}', 'ComisionController@getNovedades')->name('comisiones.getNovedades');
            Route::get('comisiones/json/{comision}', 'ComisionController@getComision')->name('comisiones.getComision');
            Route::get('comisiones/edit-puntos/{comision}', 'ComisionController@editPuntos')->name('comisiones.editPuntos');
            Route::get('comisiones/exportar', 'ComisionController@exportar')->name('comisiones.exportar');
            Route::post('comisiones/procesar/{comision}', 'ComisionController@procesar')->name('comisiones.procesar');
            Route::post('comisiones/rechazar/{comision}', 'ComisionController@rechazar')->name('comisiones.rechazar');
            Route::post('comisiones/verificar/{comision}', 'ComisionController@verificar')->name('comisiones.verificar');
            Route::post('comisiones/guardar-escoltas/{comision}', 'ComisionController@storeEscoltas')->name('comisiones.storeEscoltas');
            Route::post('comisiones/guardar-vehiculos/{comision}', 'ComisionController@storeVehiculos')->name('comisiones.storeVehiculos');
            Route::post('comisiones/guardar-puntos/{comision}', 'ComisionController@storePuntos')->name('comisiones.storePuntos');
            Route::patch('comisiones/finalizar/{comision}', 'ComisionController@finalizar')->name('comisiones.finalizar');
            Route::patch('comisiones/reiniciar/{comision}', 'ComisionController@reiniciar')->name('comisiones.reiniciar');
            Route::patch('comisiones/actualizar-puntos/{comision}', 'ComisionController@updatePuntos')->name('comisiones.updatePuntos');
            Route::get('comisiones/descargar-plantilla-excel', 'ComisionController@descargarPlantillaExcel')->name('comisiones.descargarPlantillaExcel');
            Route::post('comisiones/importar-plantilla-excel', 'ComisionController@importar')->name('comisiones.importar');
            Route::get('comisiones/ultima-importacion', 'ComisionController@ultimaImportacion')->name('comisiones.ultimaImportacion');
            Route::post('comisiones/guardar-puntos-import/{comision}', 'ComisionController@storePuntosImport')->name('comisiones.storePuntosImport');
            Route::resource('comisiones', 'ComisionController');

            Route::group(['prefix' => 'comisiones'], function () {
                //* REPORTES
                Route::get('reportes/asignar/{reporte}', 'ReporteController@asignar')->name('reportes.asignar');
                Route::get('reportes/{reporte}', 'ReporteController@show')->name('reportes.show');
                Route::post('reportes/asignar/{reporte}', 'ReporteController@guardarAsignacion')->name('reportes.guardarAsignacion');
                Route::post('reportes/aprobar/{reporte}', 'ReporteController@aprobar')->name('reportes.aprobar');
                Route::post('reportes/rechazar/{reporte}', 'ReporteController@rechazar')->name('reportes.rechazar');
            });

            //* ESCOLTAS
            Route::resource('escoltas', 'EscoltaController')->except(['show']);
            Route::match(['patch','post'],'escoltas/importar','EscoltaController@importar')->name('escoltas.importar');
            //* CLIENTES
            Route::resource('clientes', 'ClienteController')->except(['show']);
            Route::group(['prefix' => 'clientes'], function () {
                Route::get('esquema-seguridad/{clienteId}', 'EsquemaController@index')->name('esquema.index');
                Route::post('esquema-seguridad/{clienteId}', 'EsquemaController@update')->name('esquema.update');
            });

            // //* PAGOS
            // Route::get('pagos/{comision}', 'PagoController@index')->name('pagos.index');
            // Route::get('pagos/create/{comision}', '@create')->name('pagos.create');
            // Route::post('pagos/{comisionId}', 'PagoContrPagoControlleroller@store')->name('pagos.store');
            // Route::get('pagos/{comisionId}/edit', 'PagoController@edit')->name('pagos.edit');
            // Route::patch('pago/{pagoId}', 'PagoController@update')->name('pagos.update');
            // Route::delete('pagos/{pagoId}', 'PagoController@destroy')->name('pagos.destroy');
            // Route::get('pagos/download-file/{pagoId}', 'PagoController@downloadFile')->name('pagos.downloadFile');

        });

        //! RUTAS UNIÓN TEMPORAL
        Route::group(['middleware' => 'role_check:union_temporal', 'prefix' => 'union_temporal', 'as' => 'union_temporal.', 'namespace' => 'union_temporal'], function () {
            //* USUARIOS
            Route::patch('usuarios/actualiza-clave/{id}', 'UsuarioController@actualizarClave')->name('usuarios.actualizarClave');

            //* COMISIONES
            Route::get('comisiones/coordenadas', 'ComisionController@getCoordenadas')->name('comisiones.getCoordenadas');
            Route::get('comisiones/consultar-escoltas/{clienteId}', 'ComisionController@getEscoltasDisponibles')->name('comisiones.getEscoltasDisponibles');
            Route::get('comisiones/continuar/{comision}', 'ComisionController@continuar')->name('comisiones.continuar');
            Route::get('comisiones/novedades/{comision}', 'ComisionController@getNovedades')->name('comisiones.getNovedades');
            Route::get('comisiones/json/{comision}', 'ComisionController@getComision')->name('comisiones.getComision');
            Route::get('comisiones/edit-puntos/{comision}', 'ComisionController@editPuntos')->name('comisiones.editPuntos');
            Route::get('comisiones/exportar', 'ComisionController@exportar')->name('comisiones.exportar');
            Route::post('comisiones/procesar/{comision}', 'ComisionController@procesar')->name('comisiones.procesar');
            Route::post('comisiones/rechazar/{comision}', 'ComisionController@rechazar')->name('comisiones.rechazar');
            Route::post('comisiones/verificar/{comision}', 'ComisionController@verificar')->name('comisiones.verificar');
            Route::post('comisiones/guardar-escoltas/{comision}', 'ComisionController@storeEscoltas')->name('comisiones.storeEscoltas');
            Route::post('comisiones/guardar-vehiculos/{comision}', 'ComisionController@storeVehiculos')->name('comisiones.storeVehiculos');
            Route::post('comisiones/guardar-puntos/{comision}', 'ComisionController@storePuntos')->name('comisiones.storePuntos');
            Route::patch('comisiones/finalizar/{comision}', 'ComisionController@finalizar')->name('comisiones.finalizar');
            Route::patch('comisiones/reiniciar/{comision}', 'ComisionController@reiniciar')->name('comisiones.reiniciar');
            Route::patch('comisiones/actualizar-puntos/{comision}', 'ComisionController@updatePuntos')->name('comisiones.updatePuntos');
            Route::resource('comisiones', 'ComisionController');
            Route::group(['prefix' => 'comisiones'], function () {
                //* REPORTES
                Route::get('reportes/asignar/{reporte}', 'ReporteController@asignar')->name('reportes.asignar');
                Route::get('reportes/{reporte}', 'ReporteController@show')->name('reportes.show');
                Route::post('reportes/asignar/{reporte}', 'ReporteController@guardarAsignacion')->name('reportes.guardarAsignacion');
                Route::post('reportes/aprobar/{reporte}', 'ReporteController@aprobar')->name('reportes.aprobar');
                Route::post('reportes/rechazar/{reporte}', 'ReporteController@rechazar')->name('reportes.rechazar');
            });

            //* ESCOLTAS
            Route::resource('escoltas', 'EscoltaController')->except(['show']);

            //* CLIENTES
            Route::resource('clientes', 'ClienteController')->except(['show']);
            Route::group(['prefix' => 'clientes'], function () {
                Route::get('esquema-seguridad/{clienteId}', 'EsquemaController@index')->name('esquema.index');
                Route::post('esquema-seguridad/{clienteId}', 'EsquemaController@update')->name('esquema.update');
            });
        });

        //! RUTAS UNP
        Route::group(['middleware' => 'role_check:unp', 'prefix' => 'unp', 'as' => 'unp.', 'namespace' => 'unp'], function () {
            //* COMISIONES
            Route::get('comisiones/coordenadas', 'ComisionController@getCoordenadas')->name('comisiones.getCoordenadas');
            Route::get('comisiones', 'ComisionController@indexUnp')->name('comisiones.index');
            Route::get('comisiones/consultar-escoltas/{clienteId}', 'ComisionController@getEscoltasDisponibles')->name('comisiones.getEscoltasDisponibles');
            Route::get('comisiones/continuar/{comision}', 'ComisionController@continuar')->name('comisiones.continuar');
            Route::get('comisiones/novedades/{comision}', 'ComisionController@getNovedades')->name('comisiones.getNovedades');
            Route::get('comisiones/json/{comision}', 'ComisionController@getComision')->name('comisiones.getComision');
            Route::get('comisiones/exportar', 'ComisionController@exportar')->name('comisiones.exportar');
            Route::post('comisiones/procesar/{comision}', 'ComisionController@procesar')->name('comisiones.procesar');
            Route::post('comisiones/rechazar/{comision}', 'ComisionController@rechazar')->name('comisiones.rechazar');
            Route::post('comisiones/verificar/{comision}', 'ComisionController@verificar')->name('comisiones.verificar');
            Route::post('comisiones/guardar-escoltas/{comision}', 'ComisionController@storeEscoltas')->name('comisiones.storeEscoltas');
            Route::post('comisiones/guardar-vehiculos/{comision}', 'ComisionController@storeVehiculos')->name('comisiones.storeVehiculos');
            Route::post('comisiones/guardar-puntos/{comision}', 'ComisionController@storePuntos')->name('comisiones.storePuntos');
            Route::resource('comisiones', 'ComisionController')->only('show');
            Route::group(['prefix' => 'comisiones'], function () {
                //* REPORTES
                Route::get('reportes/{reporte}', 'ReporteController@show')->name('reportes.show');
            });
        });
    });
});
