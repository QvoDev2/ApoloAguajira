<?php

namespace App\Http\Controllers\todos;

use App\DataTables\todos\EscoltaDataTable;
use App\Http\Controllers\todos\Controller;
use App\Http\Requests\todos\escoltas\CreateRequest;
use App\Http\Requests\todos\escoltas\UpdateRequest;
use App\Models\Escolta;
use App\Models\Lista;
use Illuminate\Support\Facades\DB;

class EscoltaController extends Controller
{

    public function index(EscoltaDataTable $tabla)
    {
        return $tabla->render('todos.escoltas.index');
    }

    public function create()
    {
        return view('todos.escoltas.create');
    }

    public function store(CreateRequest $request)
    {
      dd($request->all());
        try {
            DB::beginTransaction();
            $escolta = Escolta::create($request->all());
            $escolta->zonas()->sync($request->zonas);
            $escolta->cargarFoto($request->file('imagen'));
            if ($request->usuario)
                $escolta->crearUsuario($request);
            DB::commit();
            return $this->redirectSuccess(route("{$this->perfil}.escoltas.index"), 'Escolta creado satisfactoriamente');
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->redirectError(route("{$this->perfil}.escoltas.index"), $th->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $escolta = Escolta::findOrFail($id);
            return view('todos.escoltas.edit', compact('escolta'));
        } catch (\Throwable $th) {
            return $this->redirectError(route("{$this->perfil}.escoltas.index"));
        }
    }

    public function update(UpdateRequest $request, $id)
    {
        try {
            $escolta = Escolta::findOrFail($id);
            DB::beginTransaction();
            $escolta->update($request->all());
            $escolta->zonas()->sync($request->zonas);
            if ($usuario = $escolta->usuario) {
                $usuario->update([
                    'nombres'   => $request->nombre,
                    'apellidos' => $request->apellidos,
                    'documento' => $request->identificacion,
                    'email'     => $request->email,
                    'celular'   => $request->celular,
                ]);
                $usuario->zonas()->sync($request->zonas);
            }
            if ($foto = $request->file('imagen'))
                $escolta->cargarFoto($foto, true);
            DB::commit();
            return $this->redirectSuccess(route("{$this->perfil}.escoltas.index"), 'Escolta actualizado satisfactoriamente');
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->redirectError(route("{$this->perfil}.escoltas.index"));
        }
    }

    public function destroy($id)
    {
        try {
            Escolta::findOrFail($id)->delete();
            return $this->responseSuccess('Escolta eliminado satisfactoriamente');
        } catch (\Throwable $th) {
            return $this->responseError($th->getMessage());
        }
    }

    public function importar(){
      $return = [];
      foreach (request()->all() as $key => $value) {
        $data = str_getcsv(base64_decode($value['file']), "\n");
        $columnas = [
          'tipo_escolta_id',
          'tipo_contrato_id',
          'identificacion',
          'nombre',
          'apellidos',
          'email',
          'ciudad_origen',
          'zonas', //array
          'celular',
          'estado',
          'usuario',
          'banco_id',
          'tipo_cuenta_id',
          'numero_cuenta',
          'empresa_id'
        ];


        foreach ($data as $key => $row) {
          if ($key==0) {continue;}
          $row = utf8_encode($row);
          $valores = array_map(function($a){return trim($a);},explode(';',$row));

          $tipoescolta = Lista::tiposEscolta()->where('nombre','like',"%$valores[0]%")->pluck('id')->toArray();
          if (count($tipoescolta)==0) {
            $id = Lista::create(['nombre'=>"Escolta $valores[0]",'tipo_lista_id' => 1])->id;
            $tipoescolta = [$id];
          }
          $valores[0] = reset($tipoescolta);
          $tipocontrato = Lista::tiposContrato()->where('nombre','like',"%$valores[1]%")->pluck('id')->toArray();
          if (count($tipocontrato)==0) {
            $id = Lista::create(['nombre'=>$valores[1],'tipo_lista_id' => 2])->id;
            $tipocontrato = [$id];
          }
          $valores[1] = reset($tipocontrato);

          $empresas = Lista::empresas()->where('nombre','like',"%$valores[13]%")->pluck('id')->toArray();
          if (count($empresas)==0) {
            $id = Lista::create(['nombre'=>$valores[13],'tipo_lista_id' => 10])->id;
            $empresas = [$id];
          }
          $valores[13] = reset($empresas);
          $request = array_combine($columnas,$valores);
          $return[] = $request;
          
        }
      }
      return  $return;
    }
}
