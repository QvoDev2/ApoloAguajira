<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $table = "pagos";

    protected $fillable = [
        'valor',
        'codigo',
        'fecha_corte',
        'fecha_pago',
        'observaciones',
        'comision_id',
    ];

    protected $dates = [
        'fecha_corte',
        'fecha_pago',
    ];

    public $casts = [
        'valor' => 'double',
        'codigo' => 'string',
        'observaciones' => 'string',
        'comision_id' => 'integer'
    ];

    public function comision()
    {
        return $this->belongsTo(Comision::class);
    }
}
