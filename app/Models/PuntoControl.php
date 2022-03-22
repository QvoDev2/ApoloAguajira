<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PuntoControl extends Model
{
    protected $table = 'puntos_control';

    public $fillable = [
        'comision_id',
        'orden',
        'longitud',
        'latitud',
        'radio',
        'lugar',
        'departamento_id'
    ];

    protected $dates = [
        'fecha_reporte'
    ];

    protected $casts = [
        'id'              => 'integer',
        'comision_id'     => 'integer',
        'orden'           => 'integer',
        'longitud'        => 'double',
        'latitud'         => 'double',
        'radio'           => 'integer',
        'lugar'           => 'string',
        'departamento_id' => 'integer'
    ];

    public function comision()
    {
        return $this->belongsTo(Comision::class, 'comision_id');
    }

    public function departamento()
    {
        return $this->belongsTo(Lista::class, 'departamento_id');
    }

    public function reportes()
    {
        return $this->hasMany(ReportePunto::class, 'punto_control_id');
    }
}
