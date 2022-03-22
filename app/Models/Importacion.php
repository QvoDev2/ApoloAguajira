<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Importacion extends Model
{
    protected $table = 'importaciones';

    protected $fillable = [
        'comision_id',
        'numero',
        'estado',
        'grupo',
        'usuario_id',
    ];

    public $casts = [
        'comision_id' => 'integer',
        'numero' => 'string',
        'estado' => 'string',
        'grupo' => 'integer',
        'usuario_id' => 'integer'
    ];

    public function getComisionAttribute()
    {
        return Comision::find($this->comision_id);
    }

    public function destinos()
    {
        return $this->hasOne(DestinoImportacion::class, 'importacion_id');
    }
}
