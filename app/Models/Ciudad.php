<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ciudad extends Model
{
    protected $table = 'ciudades';

    public $fillable = [
        'departamento_id',
        'nombre',
        'longitud',
        'latitud',
        'radio'
    ];

    protected $casts = [
        'departamento_id' => 'integer',
        'nombre'          => 'string',
        'longitud'        => 'double',
        'latitud'         => 'double',
        'radio'           => 'integer'
    ];

    public function departamento()
    {
        return $this->belongsTo(Lista::class, 'departamento_id');
    }
}
