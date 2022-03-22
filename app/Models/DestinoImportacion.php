<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DestinoImportacion extends Model
{
    protected $table = 'destinos_importaciones';

    protected $fillable = [
        'lugar',
        'importacion_id',
    ];

    public $casts = [
        'lugar' => 'string',
        'importacion_id' => 'integer'
    ];

    public function importacion()
    {
        return $this->belongsTo(Importacion::class, 'importacion_id');
    }
}
