<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Escolta extends Model
{
  protected $table = 'escoltas';

  public $dates = [
    'confirmacion_email'
  ];

  public $fillable = [
    'id',
    'tipo_contrato_id',
    'tipo_escolta_id',
    'nombre',
    'apellidos',
    'estado',
    'identificacion',
    'email',
    'confirmacion_email',
    'ciudad_origen',
    'celular',
    'empresa_id',
    'banco_id',
    'tipo_cuenta_id',
    'numero_cuenta',
    'mock_location'
  ];

  protected $casts = [
    'tipo_contrato_id'  => 'integer',
    'tipo_escolta_id'   => 'integer',
    'nombre'            => 'string',
    'apellidos'         => 'string',
    'estado'            => 'string',
    'identificacion'    => 'string',
    'email'             => 'string',
    'ciudad_origen'     => 'string',
    'celular'           => 'string',
    'empresa_id'        => 'integer',
    'banco_id'          => 'integer',
    'tipo_cuenta_id'    => 'integer',
    'numero_cuenta'     => 'string',
    'mock_location'     => 'string'
  ];

  const ESTADOS = [
  '1' => 'Activo',
  '0' => 'Inactivo'
  ];
  const DEFAULT_AVATAR = 'imagenes/default_user_image.png';

  public function tipoEscolta()
  {
    return $this->belongsTo(Lista::class, 'tipo_escolta_id');
  }

  public function tipoContrato()
  {
    return $this->belongsTo(Lista::class, 'tipo_contrato_id');
  }

  public function banco()
  {
    return $this->belongsTo(Lista::class, 'banco_id');
  }

  public function empresa()
  {
    return $this->belongsTo(Lista::class, 'empresa_id');
  }

  public function tipo_cuenta()
  {
    return $this->belongsTo(Lista::class, 'tipo_cuenta_id');
  }

  public function zonas()
  {
    return $this->belongsToMany(Lista::class, 'escoltas_zonas', 'escolta_id', 'zona_id');
  }

  public function getNombreCompletoAttribute()
  {
    return "{$this->nombre} {$this->apellidos}";
  }

  public function getRutaFotoAttribute()
  {
    $ruta = "storage/fotos_escoltas/{$this->id}";
    if (is_dir($ruta)) {
      $adjunto = array_diff(scandir($ruta),array('..', '.'));
      if (isset($adjunto[2]))
      return "{$ruta}/{$adjunto[2]}";
    }
    return self::DEFAULT_AVATAR;
  }

  public function cargarFoto($foto, $eliminar = false)
  {
    $ruta = public_path("storage/fotos_escoltas/{$this->id}");
    if (is_dir($ruta) && $eliminar) {
      $files = array_diff(scandir($ruta), array('.', '..'));
      foreach ($files as $file)
      @unlink("$ruta/$file");
    }
    if ($foto)
    $foto->store("fotos_escoltas/{$this->id}", 'public');
  }

  public function comisiones()
  {
    return $this->belongsToMany(Comision::class, 'vehiculos_escoltas', 'escolta_id', 'comision_id');
  }

  public function usuario()
  {
    return $this->hasOne(User::class, 'escolta_id');
  }

  public function crearUsuario($request)
  {
    $request['nombres']   = $request['nombre'];
    $request['documento'] = $request['identificacion'];
    $request['password']  = Hash::make("{$request['documento']}1");
    $request['perfil_id'] = Perfil::ESCOLTA;
    $this->usuario()->create($request->all())
    ->zonas()->sync($request->zonas);
  }
}
