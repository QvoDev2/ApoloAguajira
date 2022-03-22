<?php

namespace App\Models;

use Eloquent as Model;

class TipoLista extends Model
{
    public $table = 'tipo_listas';
    public $timestamps = false;

    protected $casts = [
        'id'            => 'integer',
        'nombre'        => 'string',
        'descripcion'   => 'string'
    ];

    public function listas()
    {
        return $this->hasMany(Lista::class);
    }
}
