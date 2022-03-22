<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstadoEliminado extends Model
{
    protected $table = 'estados_eliminados';

    public $fillable = [
        'observaciones',
        'comision_id',
        'estado',
        'usuario_id',
        'usuario_elimina_id',
        'created_at'
    ];

    protected $casts = [
        'id'                 => 'integer',
        'observaciones'      => 'string',
        'comision_id'        => 'integer',
        'estado'             => 'integer',
        'usuario_id'         => 'integer',
        'usuario_elimina_id' => 'integer',
    ];
}
