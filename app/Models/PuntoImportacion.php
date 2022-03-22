<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PuntoImportacion extends Model
{
    protected $table = 'puntos_importaciones';

    protected $fillable = [
        'departamento_id',
        'lugar',
        'importacion_id',
    ];

    public $casts = [
        'departamento_id' => 'integer',
        'lugar' => 'string',
        'importacion_id' => 'integer'
    ];
}
