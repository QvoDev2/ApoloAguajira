<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehiculoEscolta extends Model
{
    protected $table = 'vehiculos_escoltas';

    public $fillable = [
        'comision_id',
        'vehiculo_id',
        'escolta_id',
        'codigo_autorizacion'
    ];

    protected $casts = [
        'id'                  => 'integer',
        'comision_id'         => 'integer',
        'vehiculo_id'         => 'integer',
        'escolta_id'          => 'integer',
        'codigo_autorizacion' => 'string'
    ];

    public function comision()
    {
        return $this->belongsTo(Comision::class, 'comision_id');
    }

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class, 'vehiculo_id');
    }

    public function escolta()
    {
        return $this->belongsTo(Escolta::class, 'escolta_id');
    }
}
