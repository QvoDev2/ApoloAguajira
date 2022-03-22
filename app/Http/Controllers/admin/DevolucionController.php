<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\todos\Controller;
use App\Http\Requests\todos\devoluciones\CreateRequest;
use App\Http\Requests\todos\devoluciones\UpdateRequest;
use App\Models\Comision;
use App\Models\Devolucion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DevolucionController extends Controller
{
    public function create($comisionId)
    {
        try {
            $comision = Comision::findOrFail($comisionId);
            return view('todos.devoluciones.create', compact('comision'))->render();
        } catch (\Throwable $th) {
            return $this->responseError($th->getMessage());
        }
    }

    public function store($comisionId, CreateRequest $request)
    {
        try {
            $devolucion = Comision::findOrFail($comisionId)->devoluciones()->create($request->all());
            if (!empty($request['imagen'])) {
                $imagen = $request->file('imagen');
                $imagen->storeAs("public/devoluciones/imagenes/{$devolucion->id}", "imagen.{$imagen->getClientOriginalExtension()}");
            }
            return $this->responseSuccess('Devolución creada satisfactoriamente');
        } catch (\Throwable $th) {
            return $this->responseError($th->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $devolucion = Devolucion::findOrFail($id);
            $ruta = storage_path("app/public/devoluciones/imagenes/{$id}");
            if (is_dir($ruta))
                $imagenes = array_diff(
                    scandir($ruta),
                    array('..', '.')
                );
            else
                $imagenes = [];
            return view('todos.devoluciones.edit', compact(['devolucion', 'imagenes']));
        } catch (\Throwable $th) {
            return $this->responseError($th->getMessage());
        }
    }

    public function update(UpdateRequest $request, $id)
    {
        try {
            Devolucion::findOrFail($id)->update($request->all());
            if (!empty($request['imagen'])) {
                $imagen = $request->file('imagen');
                $imagen->storeAs("public/devoluciones/imagenes/{$id}", "imagen.jpg");
            }
            return $this->responseSuccess('Devolución actualizada satisfactoriamente');
        } catch (\Throwable $th) {
            return $this->responseError($th->getMessage());
        }
    }


    public function destroy($id)
    {
        try {
            Devolucion::findOrFail($id)->delete();
            $ruta = storage_path("app/public/devoluciones/imagenes/{$id}");
            if (is_dir($ruta))
                Storage::deleteDirectory("public/devoluciones/imagenes/{$id}");
            return $this->responseSuccess('Devolución eliminada satisfactoriamente');
        } catch (\Throwable $th) {
            return $this->responseError($th->getMessage());
        }
    }

    public function getDatos($comisionId)
    {
        $devoluciones = Devolucion::select(
            'id',
            'valor',
            DB::raw("DATE_FORMAT(fecha, '%d/%m/%Y') as fecha_n"),
            'tipo',
            'observaciones',
        )
            ->where('comision_id', $comisionId)
            ->get()
            ->toArray();
        return $devoluciones;
    }

    public function downloadFile($id)
    {
        $allFiles = Storage::files("public/devoluciones/imagenes/{$id}/");
        if (count($allFiles) > 0) {
            $pathFile = storage_path('app/' . $allFiles[0]);
            if (file_exists($pathFile)) {
                return response()->download($pathFile);
            } else {
                return false;
            }
        }
    }
}
