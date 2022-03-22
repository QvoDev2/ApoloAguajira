<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VComision extends Model
{
    protected $table = 'vcomisiones';

    protected $casts = [
        'id'                           => 'integer',
        'paso_creacion'                => 'integer',
        'numero'                       => 'string',
        'valor_x_dia'                  => 'double',
        'observaciones'                => 'string',
        'cliente_id'                   => 'integer',
        'usuario_id'                   => 'integer',
        'estado'                       => 'integer',
        'dias_aprobados'               => 'double',
        'dias_reales'                  => 'double',
        'observaciones_verificaciones' => 'string',
        'medio_desplazamiento'         => 'string',
        'zona_id'                      => 'integer',
    ];

    protected $dates = [
        'fecha_aprobacion_correo',
        'fecha_inicio',
        'fecha_fin',
    ];

    public function getAccionesAttribute()
    {
        return Comision::ACCIONES[$this->estado];
    }

    public function getEstadoTextoAttribute()
    {
        return Comision::ESTADOS[$this->estado];
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function vehiculosEscoltas()
    {
        return $this->hasMany(VehiculoEscolta::class, 'comision_id');
    }

    public function escoltas()
    {
        return $this->belongsToMany(Escolta::class, 'vehiculos_escoltas', 'comision_id', 'escolta_id');
    }

    public function getEscoltaAttribute()
    {
        return $this->escoltas()->first();
    }

    public function puntosControl()
    {
        return $this->hasMany(PuntoControl::class, 'comision_id');
    }

    public function estados()
    {
        return $this->hasMany(EstadoComision::class, 'comision_id')->orderBy('created_at', 'DESC');
    }
}
