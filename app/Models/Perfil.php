<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    protected $table = 'perfiles';

    const UT = 2;
    const ESCOLTA = 4;

    protected $casts = [
        'codigo' => 'string',
        'nombre' => 'string'
    ];

    public $timestamps = false;
}
