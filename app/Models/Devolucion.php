<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Devolucion extends Model
{
    protected $table = "devoluciones";

    protected $fillable = [
        'valor',
        'fecha',
        'tipo',
        'numero',
        'observaciones',
        'comision_id',
    ];

    protected $dates = [
        'fecha',
    ];

    public $casts = [
        'valor' => 'double',
        'tipo' => 'string',
        'numero' => 'string',
        'observaciones' => 'string',
        'observaciones' => 'string',
        'comision_id' => 'integer'
    ];

    public function comision()
    {
        return $this->belongsTo(Comision::class);
    }
}
