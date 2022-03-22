<?php

namespace App\Models;

use Eloquent as Model;

class Lista extends Model
{
    public $fillable = [
        'codigo',
        'nombre',
        'descripcion',
        'lista_id',
        'tipo_lista_id'
    ];

    protected $casts = [
        'id'            => 'integer',
        'codigo'        => 'string',
        'nombre'        => 'string',
        'descripcion'   => 'string',
        'lista_id'      => 'integer',
        'tipo_lista_id' => 'integer',
        'editable'      => 'boolean'
    ];

    public function tipo()
    {
        return $this->belongsTo(TipoLista::class);
    }

    public function padre()
    {
        return $this->belongsTo(Lista::class, 'lista_id');
    }

    public static function tiposEscolta()
    {
        return self::where('tipo_lista_id', 1);
    } 

    public static function tiposContrato()
    {
        return self::where('tipo_lista_id', 2);
    }
     
    public static function empresas()
    {
        return self::where('tipo_lista_id', 10);
    } 

    public static function bancos()
    {
        return self::where('tipo_lista_id', 11);
    } 

    public static function tiposCuenta()
    {
        return self::where('tipo_lista_id', 12);
    } 

    public static function tiposVehiculo()
    {
        return self::where('tipo_lista_id', 3);
    }

    public static function departamentos()
    {
        return self::where('tipo_lista_id', 5);
    } 

    public static function ciudades()
    {
        return self::where('tipo_lista_id', 6);
    }     

    public static function zonas()
    {
        return self::where('tipo_lista_id', 7);
    }     

    public static function motivosRechazo()
    {
        return self::where('tipo_lista_id', 8);
    }

    public static function tiposDesplazamiento()
    {
        return self::where('tipo_lista_id', 9);
    }

    public function usuarios() // Usuarios por zona
    {
        return $this->belongsToMany(User::class, 'usuarios_zonas', 'zona_id', 'usuario_id');
    }

    public function comisiones() // Comisiones por zona
    {
        return $this->hasMany(VComision::class, 'zona_id');
    }

    public static function findByNombre($nombre, $id)
    {
        return self::where('tipo_lista_id', $id)->where('nombre', $nombre)->first();
    }
}
