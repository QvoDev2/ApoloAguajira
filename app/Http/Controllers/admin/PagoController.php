<?php

namespace App\Http\Controllers\admin;

use App\DataTables\todos\PagoDataTable;
use App\Http\Controllers\todos\Controller;
use App\Http\Requests\todos\pagos\CreateRequest;
use App\Http\Requests\todos\pagos\UpdateRequest;
use App\Models\Comision;
use App\Models\Pago;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PagoController extends Controller
{
    public function index(Comision $comision, PagoDataTable $table)
    {
        return $table->render('todos.pagos.index', compact(['comision']));
    }

    public function create($comisionId)
    {
        try {
            $comision = Comision::findOrFail($comisionId);
            return view('todos.pagos.create', compact('comision'))->render();
        } catch (\Throwable $th) {
            return $this->responseError($th->getMessage());
        }
    }

    public function store($comisionId, CreateRequest $request)
    {
        try {
            $comision = Comision::findOrFail($comisionId)->pagos()->create($request->all());
            if (!empty($request['imagen'])) {
                $imagen = $request->file('imagen');
                $imagen->storeAs("public/pagos/imagenes/{$comision->id}", "imagen.{$imagen->getClientOriginalExtension()}");
            }
            return $this->responseSuccess('Pago creado satisfactoriamente');
        } catch (\Throwable $th) {
            return $this->responseError($th->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $pago = Pago::findOrFail($id);
            $ruta = storage_path("app/public/pagos/imagenes/{$id}");
            if (is_dir($ruta))
                $imagenes = array_diff(
                    scandir($ruta),
                    array('..', '.')
                );
            else
                $imagenes = [];
            return view('todos.pagos.edit', compact(['pago', 'imagenes']));
        } catch (\Throwable $th) {
            return $this->responseError($th->getMessage());
        }
    }

    public function update(UpdateRequest $request, $id)
    {
        try {
            Pago::findOrFail($id)->update($request->all());
            if (!empty($request['imagen'])) {
                $imagen = $request->file('imagen');
                $imagen->storeAs("public/pagos/imagenes/{$id}", "imagen.jpg");
            }
            return $this->responseSuccess('Pago actualizado satisfactoriamente');
        } catch (\Throwable $th) {
            return $this->responseError($th->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            Pago::findOrFail($id)->delete();
            $ruta = storage_path("app/public/pagos/imagenes/{$id}");
            if (is_dir($ruta))
                Storage::deleteDirectory("public/pagos/imagenes/{$id}");
            return $this->responseSuccess('Pago eliminado satisfactoriamente');
        } catch (\Throwable $th) {
            return $this->responseError($th->getMessage());
        }
    }

    public function downloadFile($id)
    {
        $allFiles = Storage::files("public/pagos/imagenes/{$id}/");
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
