<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';

    public $fillable = [
        'nombre',
        'zona_id',
        'ciudad_id',
    ];

    protected $casts = [
        'nombre'    => 'string',
        'zona_id'   => 'integer',
        'ciudad_id' => 'integer',
    ];

    public function zona()
    {
        return $this->belongsTo(Lista::class, 'zona_id');
    }

    public function ciudad()
    {
        return $this->belongsTo(Lista::class, 'ciudad_id');
    }

    public function escoltas()
    {
        return $this->belongsToMany(Escolta::class, 'clientes_escoltas', 'cliente_id', 'escolta_id')->withPivot(['fecha_vinculacion', 'fecha_retiro']);
    }

    public function getEscoltasDisponiblesQueryAttribute()
    {
        return Escolta::select('escoltas.*')
            ->join('escoltas_zonas', 'escoltas.id', 'escoltas_zonas.escolta_id')
            ->whereNotIn('escoltas.id', $this->escoltas()->pluck('id')->toArray())
            ->where('escoltas_zonas.zona_id', $this->zona_id)
            ->where('escoltas.estado', '1')
            ->with('zonas')
            ->groupBy('escoltas.id');
    }

    public function getEscoltasDisponiblesAttribute()
    {
        return $this->escoltas_disponibles_query->get();
    }

    public function getEscoltasActivosAttribute()
    {
        return $this->escoltas()
            ->where('escoltas.estado', '1')
            ->whereNull('fecha_retiro')
            ->groupBy('id');
    }
}
