<?php

namespace App\Http\Requests\todos\vehiculos;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    
    public function rules()
    {
        return [
            'id'                => 'exists:vehiculos,id',
            'nombre'            => 'required|max:45',
            'tipo_vehiculo_id'  => 'required|exists:listas,id',
            'placa'             => 'required|max:45',
            'modelo'            => 'required|max:45',
            'marca'             => 'required|max:45'
        ];
    }

    public function messages()
    {
        return [
            'id.exists'                 => 'El vehículo no fue econtrado',
            'nombre.required'           => 'El nombre es requerido',
            'nombre.max'                => 'El nombre supera la longitud máxima',
            'tipo_vehiculo_id.required' => 'El tipo vehículo es requerido',
            'tipo_vehiculo_id.exists'   => 'El tipo vehículo no fue encontrado',
            'placa.required'            => 'La placa es requerido',
            'placa.max'                 => 'La placa supera la longitud máxima',
            'modelo.required'           => 'El modelo es requerido',
            'modelo.max'                => 'El modelo supera la longitud máxima',
            'marca.required'            => 'La marca es requerido',
            'marca.max'                 => 'La marca supera la longitud máxima'
        ];
    }
}
