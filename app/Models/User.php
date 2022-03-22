<?php

namespace App\Models;

use App\Notifications\ResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $fillable = [
        'nombres',
        'apellidos',
        'documento',
        'email',
        'celular',
        'password',
        'perfil_id',
        'escolta_id',
        'estado',
        'token_firebase'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'nombres'    => 'string',
        'apellidos'  => 'string',
        'documento'  => 'string',
        'email'      => 'string',
        'celular'    => 'string',
        'password'   => 'string',
        'perfil_id'  => 'integer',
        'escolta_id' => 'integer',
        'estado'     => 'boolean',
        'token_firebase' => 'string'
    ];

    public function perfil()
    {
        return $this->belongsTo(Perfil::class, 'perfil_id');
    }

    public function escolta()
    {
        return $this->belongsTo(Escolta::class, 'escolta_id');
    }

    public function zonas()
    {
        return $this->belongsToMany(Lista::class, 'usuarios_zonas', 'usuario_id', 'zona_id');
    }

    public function getDescripcionZonaAttribute()
    {
        return ($zona = $this->zonas()->first())
            ? $zona->descripcion
            : '';
    }

    public function getArrayZonasAttribute()
    {
        return $this->zonas()->pluck('id')->toArray();
    }

    public function clientes()
    {
        return $this->belongsToMany(Cliente::class, 'usuarios_zonas', 'usuario_id', 'zona_id', 'id', 'zona_id')
            ->groupBy('clientes.id');
    }

    public function comisiones()
    {
        return $this->hasMany(Comision::class, 'usuario_id');
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function getNombreCompletoAttribute()
    {
        return "{$this->nombres} {$this->apellidos}";
    }

    public function puedeCambiarCoordenadas()
    {
        return in_array($this->id, [70]);
    }
}
