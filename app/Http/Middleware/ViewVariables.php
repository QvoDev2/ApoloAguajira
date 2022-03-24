<?php

namespace App\Http\Middleware;

use App\Models\Comision;
use App\Models\Escolta;
use App\Models\Lista;
use App\Models\Perfil;
use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class ViewVariables
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
        $this->todos();
        if ($perfil = auth()->user()->perfil->codigo ?? null)
            $this->$perfil();
        return $next($request);
    }

    public function todos()
    {
        //* Configuraciones globales de bootstrap para los campos
        View::composer(['*'], function ($view) {
            $select = ['class' => 'form-control selectpicker bordered', 'data-style' => 'form-control', 'data-live-search' => 'true', 'title' => 'Seleccione'];
            $selectMultiple = ['class' => 'form-control selectpicker bordered', 'data-style' => 'form-control', 'data-live-search' => 'true', 'title' => 'Seleccione', 'multiple', 'data-actions-box' => 'true'];
            $input = ['class' => 'form-control'];
            $moneda = ['class' => 'form-control maskmoney'];
            $datetimepicker = ['class' => 'form-control datetimepicker', 'autocomplete' => 'no'];
            $textarea = ['class' => 'form-control', 'rows' => '5'];
            $button = ['class' => 'btn btn-primary'];

            $selectFiltro = ['class' => 'form-control selectpicker bordered filtro', 'data-style' => 'form-control', 'data-live-search' => 'true'];
            $selectFiltroMultiple = ['class' => 'form-control selectpicker bordered filtro', 'data-style' => 'form-control', 'data-live-search' => 'true', 'title' => 'Seleccione', 'multiple', 'data-actions-box' => 'true'];
            $inputFiltro = ['class' => 'form-control filtro'];
            $sesion = auth()->user();

            $view->with(compact('select', 'selectFiltro', 'selectFiltroMultiple', 'selectMultiple', 'input', 'inputFiltro', 'button', 'textarea', 'datetimepicker', 'moneda', 'sesion'));
        });

        //* Alerta de confirmación (Todos los index)
        View::composer(['*index'], function ($view) {
            $script = view('layouts.confirmacion_eliminar')->render();
            $view->with('scriptConfirmacion', $script);
        });

        //* Datos fltros CRUD clientes
        View::composer(['todos.usuarios.index'], function ($view) {
            $perfiles = Perfil::pluck('nombre', 'id')->toArray();
            $view->with(compact('perfiles'));
        });

        //* Datos select CRUD usuarios
        View::composer(['todos.usuarios.fields'], function ($view) {
            $perfiles = Perfil::pluck('nombre', 'id')->toArray();
            $escoltas = Escolta::selectRaw('CONCAT(nombre, " ", apellidos) nombre, id')->pluck('nombre', 'id')->toArray();
            $zonas = auth()->user()->id == 1 ?
                Lista::zonas()->pluck('nombre', 'id')->toArray() : auth()->user()->zonas()->pluck('nombre', 'id')->toArray();
            $view->with(compact('perfiles', 'zonas', 'escoltas'));
        });

        //* Datos select CRUD listas
        View::composer(['todos.parametrizacion.listas.fields'], function ($view) {
            $listas = Lista::selectRaw('IF(codigo IS NULL, nombre, CONCAT(codigo, " - ", nombre)) nombre, id')->pluck('nombre', 'id')->prepend('Seleccione...', '')->toArray();
            $view->with(compact('listas'));
        });

        //* Datos select CRUD vehículos
        View::composer(['todos.vehiculos.fields'], function ($view) {
            $tipos = Lista::tiposVehiculo()->pluck('nombre', 'id')->toArray();
            $view->with(compact('tipos'));
        });

        //* Datos fltros CRUD escoltas
        View::composer(['todos.escoltas.index'], function ($view) {
            $tiposEscolta = Lista::tiposEscolta()->pluck('nombre', 'id')->toArray();
            $zonas = auth()->user()->zonas()->pluck('nombre', 'id')->toArray();
            $view->with(compact('tiposEscolta', 'zonas'));
        });

        //* Datos select CRUD escoltas
        View::composer(['todos.escoltas.fields'], function ($view) {
            $tiposEscolta = Lista::tiposEscolta()->pluck('nombre', 'id')->toArray();
            $tiposContrato = Lista::tiposContrato()->pluck('nombre', 'id')->toArray();
            $estados = Escolta::ESTADOS;
            $zonas = auth()->user()->id == 1 ? Lista::zonas()->pluck('nombre', 'id')->toArray() : auth()->user()->zonas()->pluck('nombre', 'id')->toArray();
            // $zonas = auth()->user()->zonas()->pluck('nombre', 'id')->toArray();
            $empresas = Lista::empresas()->pluck('nombre', 'id')->toArray();
            $bancos = Lista::bancos()->pluck('nombre', 'id')->toArray();
            $tiposCuenta = Lista::tiposCuenta()->pluck('nombre', 'id')->toArray();
            $view->with(compact('tiposEscolta', 'tiposContrato', 'estados', 'zonas', 'empresas', 'bancos', 'tiposCuenta'));
        });

        //* Datos fltros CRUD clientes
        View::composer(['todos.clientes.index'], function ($view) {
            $zonas = auth()->user()->zonas()->pluck('nombre', 'id')->toArray();
            $view->with(compact('zonas'));
        });

        //* Datos select CRUD clientes
        View::composer(['todos.clientes.fields'], function ($view) {
            $zonas = auth()->user()->zonas()->pluck('nombre', 'id')->toArray();
            $ciudades = Lista::ciudades()->select(DB::raw("CONCAT((SELECT nombre FROM listas l2 WHERE l2.id = listas.lista_id), ' - ', nombre) nombre"), 'id')->pluck('nombre', 'id')->toArray();
            $view->with(compact('zonas', 'ciudades', 'ciudades'));
        });

        //* Datos filtro CRUD comisiones
        View::composer(['todos.comisiones.index'], function ($view) {
            $clientes = auth()->user()->clientes()->pluck('nombre', 'id')->toArray();
            $zonas = auth()->user()->zonas()->pluck('nombre', 'id')->toArray();
            $estados = Comision::ESTADOS;
            $motivosRechazo = Lista::motivosRechazo()->pluck('nombre', 'id')->toArray();
            $view->with(compact('clientes', 'estados', 'zonas', 'motivosRechazo'));
        });

        //* Datos select CRUD comisiones
        View::composer(['todos.comisiones.paso1', 'todos.comisiones.edit'], function ($view) {
            $clientes = auth()->user()->clientes;
            $tiposDesplazamiento = Lista::tiposDesplazamiento()->pluck('nombre', 'id')->toArray();
            $departamentos = Lista::departamentos()->pluck('nombre', 'id')->toArray();
            $view->with(compact('clientes', 'tiposDesplazamiento', 'departamentos'));
        });

        //* Datos select CRUD comisiones
        View::composer(['todos.comisiones.paso3', 'todos.comisiones.edit_puntos', 'todos.comisiones.imports.ultimaImportacion', 'todos.parametrizacion.ciudades.fields'], function ($view) {
            $departamentos = Lista::departamentos()->pluck('nombre', 'id')->toArray();
            $view->with(compact('departamentos'));
        });

        //* Datos select CRUD devoluciones
        View::composer('todos.devoluciones.fields', function ($view) {
            $tipos = ['Descuento de nomina LC' => 'Descuento de nomina LC', 'Descuento de nomina LN' => 'Descuento de nomina LN', 'Consignacion' => 'Consignacion', 'Transferencia' => 'Transferencia', 'Deposito' => 'Deposito'];
            $view->with(compact('tipos'));
        });
    }

    public function admin()
    {
        View::composer(['*'], function ($view) {
            $perfil = 'admin';
            $view->with(compact('perfil'));
        });
    }

    public function ut()
    {
        View::composer(['*'], function ($view) {
            $perfil = 'ut';
            $view->with(compact('perfil'));
        });
    }
    public function escolta(){
        View::composer(['*'], function ($view) {
          $perfil = 'escolta';
          $view->with(compact('perfil'));
        });
    }

    public function union_temporal()
    {
        View::composer(['*'], function ($view) {
            $perfil = 'union_temporal';
            $view->with(compact('perfil'));
        });

        //* Datos select CRUD comisiones
        View::composer(['union_temporal.comisiones.paso3', 'union_temporal.comisiones.edit_puntos'], function ($view) {
            $departamentos = Lista::departamentos()->pluck('nombre', 'id')->toArray();
            $view->with(compact('departamentos'));
        });
    }

    public function unp()
    {
        View::composer(['*'], function ($view) {
            $perfil = 'unp';
            $view->with(compact('perfil'));
        });

        //* Datos filtro CRUD comisiones
        View::composer(['unp.comisiones.index'], function ($view) {
            $clientes = auth()->user()->clientes()->pluck('nombre', 'id')->toArray();
            $zonas = auth()->user()->zonas()->pluck('nombre', 'id')->toArray();
            $estados = [
                Comision::ESTADO_VERIFICADO_UT => 'VERIFICADO UT',
                Comision::ESTADO_NOVEDAD       => 'NOVEDAD',
                Comision::ESTADO_APROBADO      => 'APROBADO UNP',
                Comision::ESTADO_RECHAZADO     => 'RECHAZADO UNP'
            ];
            $motivosRechazo = Lista::motivosRechazo()->pluck('nombre', 'id')->toArray();
            $view->with(compact('clientes', 'estados', 'zonas', 'motivosRechazo'));
        });
    }
}
