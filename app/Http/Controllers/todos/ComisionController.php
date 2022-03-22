<?php

namespace App\Http\Controllers\todos;

use App\DataTables\todos\ComisionDataTable;
use App\Exports\todos\ComisionesExport;
use App\Exports\todos\PlantillaComisiones;
use App\Http\Controllers\todos\Controller;
use App\Http\Requests\todos\comisiones\CreateRequest;
use App\Http\Requests\todos\comisiones\StoreEscoltasRequest;
use App\Http\Requests\todos\comisiones\storePuntosRequest;
use App\Http\Requests\todos\comisiones\UpdatePuntosRequest;
use App\Http\Requests\todos\comisiones\UpdateRequest;
use App\Imports\todos\ImportComisiones;
use App\Models\Ciudad;
use App\Models\Cliente;
use App\Models\Comision;
use App\Models\Escolta;
use App\Models\Importacion;
use App\Models\Lista;
use App\Models\PuntoControl;
use App\Notifications\CreacionComision;
use App\Notifications\VerificadoComision;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ComisionController extends Controller
{
    public function index(ComisionDataTable $tabla)
    {
        return $tabla->render('todos.comisiones.index');
    }

    public function create()
    {
        return view('todos.comisiones.paso1');
    }

    public function getComision(Comision $comision)
    {
        return $comision;
    }

    public function getNovedades(Comision $comision)
    {
        return view('todos.comisiones.novedades', compact('comision'));
    }

    public function store(CreateRequest $request)
    {
        try {
            $cliente = Cliente::findOrFail($request->cliente_id);
            DB::beginTransaction();
            $ciudad = Ciudad::firstOrCreate([
                'departamento_id' => $request->departamento_id,
                'nombre'          => $request->origen
            ]);
            $request['ciudad_id'] = $ciudad->id;
            $request['zona_id'] = $cliente->zona_id;
            $comision = auth()->user()->comisiones()->create($request->all());
            DB::commit();
            return $this->redirectSuccess(route("{$this->perfil}.comisiones.continuar", $comision->id), 'Comisión almacenada satisfactoriamente');
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->redirectError(route("{$this->perfil}.comisiones.index"));
        }
    }

    public function continuar(Comision $comision)
    {
        try {
            return view("todos.comisiones.paso{$comision->paso_creacion}", compact('comision'));
        } catch (\Throwable $th) {
            return $this->redirectError(route("{$this->perfil}.comisiones.index"));
        }
    }

    public function edit(Comision $comisione)
    {
        try {
            return view('todos.comisiones.edit', compact('comisione'));
        } catch (\Throwable $th) {
            return $this->redirectError(route("{$this->perfil}.comisiones.index"));
        }
    }

    public function update(Comision $comisione, UpdateRequest $request)
    {
        try {
            $cliente = Cliente::findOrFail($request->cliente_id);
            $comisione->update($request->all() + ['zona_id' => $cliente->zona_id]);
            return $this->redirectSuccess(route("{$this->perfil}.comisiones.editPuntos", $comisione->id), 'Comisión actualizada satisfactoriamente');
        } catch (\Throwable $th) {
            return $this->redirectError(route("{$this->perfil}.comisiones.index"));
        }
    }

    public function reiniciar(Comision $comision)
    {
        try {
            if ($comision->estado == $comision::ESTADO_FINALIZADO) {
                DB::beginTransaction();
                $estado = $comision->estados()
                    ->where('estado', $comision::ESTADO_FINALIZADO)
                    ->first();
                $comision->estadosEliminados()->create([
                    'observaciones'      => $estado->observaciones,
                    'estado'             => $estado->estado,
                    'usuario_id'         => $estado->usuario_id,
                    'usuario_elimina_id' => auth()->user()->id,
                ]);
                $estado->delete();
                DB::commit();
            } else
                return $this->responseError('No es posible reiniciar la comisión');
            return $this->responseSuccess('Comisión reiniciada satisfactoriamente');
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->responseError('No es posible reiniciar la comisión');
        }
    }

    public function finalizar(Comision $comision)
    {
        try {
            if ($comision->estado == $comision::ESTADO_EN_CURSO) {
                $estado = $comision->estados()->create([
                    'observaciones' => '',
                    'estado'        => Comision::ESTADO_FINALIZADO,
                    'usuario_id'    => $comision->escolta->usuario->id ?? auth()->user()->id
                ]);
                $estado->created_at = $comision->getFechaReporte('max');
                $estado->update();
            } else
                return $this->responseError('No es posible finalizar la comisión');
            return $this->responseSuccess('Comisión finalizada satisfactoriamente');
        } catch (\Throwable $th) {
            return $this->responseError("No es posible finalizar la comisión. {$th->getMessage()}");
        }
    }

    public function editPuntos(Comision $comision)
    {
        try {
            return view('todos.comisiones.edit_puntos', compact('comision'));
        } catch (\Throwable $th) {
            return $this->redirectError(route("{$this->perfil}.comisiones.index"));
        }
    }

    public function updatePuntos(Comision $comision, UpdatePuntosRequest $request)
    {
        try {
            DB::beginTransaction();
            foreach ($request->departamentos as $key => $departamento) {
                $data = [
                    'departamento_id' => $departamento,
                    'orden'           => $key + 1,
                    'latitud'         => $request->latitudes[$key],
                    'longitud'        => $request->longitudes[$key],
                    'radio'           => $request->radios[$key],
                    'lugar'           => $request->lugares[$key]
                ];
                if (isset($request->ids[$key]))
                    PuntoControl::find($request->ids[$key])->update($data);
                else
                    $comision->puntosControl()->create($data);
            }
            DB::commit();
            return $this->responseSuccess('Puntos de control actualizados satisfactoriamente');
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->responseError($th->getMessage());
        }
    }

    public function storeEscoltas(Comision $comision, StoreEscoltasRequest $request)
    {
        try {
            DB::beginTransaction();
            $comision->update([
                'paso_creacion' => 3
            ]);
            $comision->vehiculosEscoltas()->createMany($request->escoltas);
            DB::commit();
            return $this->responseSuccess('Escoltas almacenados satisfactoriamente');
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->responseError($th->getMessage());
        }
    }

    public function storePuntos(Comision $comision, storePuntosRequest $request)
    {
        try {
            DB::beginTransaction();
            $comision->update([
                'paso_creacion' => 0
            ]);
            foreach ($request->departamentos as $key => $departamento)
                $comision->puntosControl()->create([
                    'departamento_id' => $departamento,
                    'orden'           => $key + 1,
                    'latitud'         => $request->latitudes[$key],
                    'longitud'        => $request->longitudes[$key],
                    'radio'           => $request->radios[$key],
                    'lugar'           => $request->lugares[$key]
                ]);
            $comision->estados()->create([
                'observaciones' => '',
                'estado'        => ($comision->tipo != 1) ? Comision::ESTADO_ASIGNADO : Comision::SOLO_DESPLAZAMIENTO,
                'usuario_id'    => auth()->user()->id
            ]);
            $comision->replicar();
            DB::commit();
            return $this->responseSuccess('Puntos de control almacenados satisfactoriamente');
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->responseError($th->getMessage());
        }
    }

    public function verificar(Comision $comision, Request $request)
    {
        try {
            if (in_array($request->estado, $comision->posibles_estados)) {
                $comision->update(['dias_reales' => $request->dias_reales]);
                $comision->estados()->create([
                    'observaciones' => $request->observaciones,
                    'estado'        => $request->estado,
                    'usuario_id'    => auth()->user()->id
                ]);
                $comision->escolta->usuario->notify(new VerificadoComision($comision, $request->observaciones));
            } else
                return $this->responseError('No es posible procesar la comisión');
            return $this->responseSuccess('Comisión procesada satisfactoriamente');
        } catch (\Throwable $th) {
            return $this->responseError($th->getMessage());
        }
    }

    public function procesar(Comision $comision, Request $request)
    {
        try {
            if (in_array($request->estado, $comision->posibles_estados)) {
                $comision->estados()->create([
                    'observaciones' => $request->observaciones,
                    'estado'        => $request->estado,
                    'usuario_id'    => auth()->user()->id
                ]);
            } else
                return $this->responseError('No es posible procesar la comisión');
            return $this->responseSuccess('Comisión procesada satisfactoriamente');
        } catch (\Throwable $th) {
            return $this->responseError($th->getMessage());
        }
    }

    public function rechazar(Comision $comision, Request $request)
    {
        try {
            if (in_array($request->estado, $comision->posibles_estados))
                $comision->estados()->create([
                    'observaciones' => (Lista::find($request->motivo)->nombre ?? '') . ' - ' . $request->observaciones,
                    'estado'        => $request->estado,
                    'usuario_id'    => auth()->user()->id
                ]);
            else
                return $this->responseError('No es posible procesar la comisión');
            return $this->responseSuccess('Comisión procesada satisfactoriamente');
        } catch (\Throwable $th) {
            return $this->responseError($th->getMessage());
        }
    }

    public function show(Comision $comisione)
    {
        try {
            return view('todos.comisiones.show', compact('comisione'))->render();
        } catch (\Throwable $th) {
            return $this->responseError($th->getMessage());
        }
    }

    public function exportar(Request $request)
    {
        return Excel::download(new ComisionesExport($request), 'Comisiones.xlsx');
    }

    public function getEscoltasDisponibles($clienteId, Request $request)
    {
        try {
            $cliente = Cliente::findOrFail($clienteId);
            $escoltasActivos = $cliente->escoltas_activos
                ->whereNotIn('id', $request->escoltas ?? [])
                ->where(function ($q) use ($request) {
                    $q->where(DB::raw('CONCAT(nombre, " ", apellidos)'), 'like', "%{$request->filtro}%")
                        ->orWhere('identificacion', 'like', "%{$request->filtro}%");
                })
                ->limit(5)
                ->get();
            $esoltasDisponibles = $cliente->escoltas_disponibles_query
                ->whereNotIn('id', $request->escoltas ?? [])
                ->where(function ($q) use ($request) {
                    $q->where(DB::raw('CONCAT(nombre, " ", apellidos)'), 'like', "%{$request->filtro}%")
                        ->orWhere('identificacion', 'like', "%{$request->filtro}%");
                })->limit(5)
                ->get();
            return view('todos.comisiones.escoltas_disponibles', compact('escoltasActivos', 'esoltasDisponibles'))->render();
        } catch (\Throwable $th) {
            return $this->responseError($th->getMessage());
        }
    }

    public function destroy(Comision $comisione)
    {
        try {
            DB::beginTransaction();
            $comisione->vehiculosEscoltas()->delete();
            $comisione->delete();
            DB::commit();
            return $this->responseSuccess('Comisión eliminada satisfactoriamente');
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->responseError($th->getMessage());
        }
    }

    public function getCoordenadas(Request $request)
    {
        try {
            return PuntoControl::select('latitud', 'longitud', 'radio')
                ->where('departamento_id', $request->departamento)
                ->where('lugar', 'LIKE', $request->lugar)
                ->latest()
                ->first();
        } catch (\Throwable $th) {
            return $this->responseError($th->getMessage());
        }
    }

    public function descargarPlantillaExcel()
    {
        return Excel::download(new PlantillaComisiones, 'PlantillaComisiones.xlsx');
    }

    public function importar(Request $request)
    {
        try {
            Excel::import(new ImportComisiones, $request->file('adjunto'));
            return $this->responseSuccess('Se importó correctamente');
        } catch (\Throwable $th) {
            return $this->responseError($th->getMessage());
        }
    }

    public function ultimaImportacion()
    {
        try {
            $imports = Importacion::where('estado', '<>', 5)->where('usuario_id', auth()->user()->id)->get();
            return view('todos.comisiones.imports.ultimaImportacion', compact('imports'))->render();
        } catch (\Throwable $th) {
            return $this->responseError($th->getMessage());
        }
    }

    public function storePuntosImport(Comision $comision, storePuntosRequest $request)
    {
        try {
            DB::beginTransaction();
            $puntos = $comision->puntosControl()->get();
            $comision->update([
                'paso_creacion' => 0
            ]);
            foreach ($request->departamentos as $key => $departamento) {
                $data = [
                    'departamento_id' => $departamento,
                    'orden'           => $key + 1,
                    'latitud'         => $request->latitudes[$key],
                    'longitud'        => $request->longitudes[$key],
                    'radio'           => $request->radios[$key],
                    'lugar'           => $request->lugares[$key]
                ];
                if (!empty($puntos) && $key < count($puntos))
                    $puntos[$key]->update($data);
                else
                    $comision->puntosControl()->create($data);
            }
            $comision->estados()->create([
                'observaciones' => '',
                'estado'        => ($comision->tipo != 1) ? Comision::ESTADO_ASIGNADO : Comision::SOLO_DESPLAZAMIENTO,
                'usuario_id'    => auth()->user()->id
            ]);
            $import = Importacion::where('comision_id', $comision->id)->first();
            $import->estado = 5;
            $import->save();

            foreach ($comision->vehiculosEscoltas as $escolta) {
                if ($usuario = (Escolta::find($escolta->escolta_id)->usuario ?? null))
                    $usuario->notify(new CreacionComision($comision, $usuario));
            }

            DB::commit();
            return $this->responseSuccess([
                'comision_id' => $comision->id,
                'msg' => 'Puntos de control almacenados satisfactoriamente'
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->responseError($th->getMessage());
        }
    }
}
