<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VComisionTable extends Model
{
    protected $table = 'vcomisiones_table';

    protected $casts = [
        'id'                           => 'integer',
        'paso_creacion'                => 'integer',
        'numero'                       => 'string',
        'valor_x_dia'                  => 'double',
        'observaciones'                => 'string',
        'cliente_id'                   => 'integer',
        'usuario_id'                   => 'integer',
        'novedades'                    => 'integer',
        'estado'                       => 'integer',
        'dias_aprobados'               => 'double',
        'dias_reales'                  => 'double',
        'observaciones_verificaciones' => 'string',
        'medio_desplazamiento'         => 'string',
    ];

    protected $dates = [
        'fecha_aprobacion_correo',
        'fecha_inicio',
        'fecha_fin',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function getEstadoTextoAttribute()
    {
        return Comision::ESTADOS[$this->estado];
    }

    public function getAccionesAttribute()
    {
        return Comision::ACCIONES[$this->estado];
    }
}
