<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    protected $table = 'vehiculos';

    public $fillable = [
        'nombre',
        'tipo_vehiculo_id',
        'placa',
        'modelo',
        'marca'
    ];

    protected $casts = [
        'nombre' =>           'string',
        'tipo_vehiculo_id' => 'integer',
        'placa' =>            'string',
        'modelo' =>           'string',
        'marca' =>            'string'
    ];

    public function tipo()
    {
        return $this->belongsTo(Lista::class, 'tipo_vehiculo_id');
    }
}
