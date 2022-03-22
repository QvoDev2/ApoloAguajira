<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstadoComision extends Model
{
    protected $table = 'estados_comisiones';

    public $fillable = [
        'observaciones',
        'comision_id',
        'estado',
        'usuario_id',
    ];

    protected $casts = [
        'id'            => 'integer',
        'observaciones' => 'string',
        'comision_id'   => 'integer',
        'estado'        => 'integer',
        'usuario_id'    => 'integer'
    ];

    public function getEstadoTextoAttribute()
    {
        return Comision::ESTADOS[$this->estado];
    }

    public function comision()
    {
        return $this->belongsTo(Comision::class, 'comision_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
