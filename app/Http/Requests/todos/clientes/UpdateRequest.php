<?php

namespace App\Http\Requests\todos\clientes;

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
            'id'        => 'exists:clientes,id',
            'nombre'    => 'required|max:400',
            'zona_id'   => 'required|exists:listas,id',
            'ciudad_id' => 'required|exists:listas,id',
        ];
    }

    public function messages()
    {
        return [
            'id.exists'          => 'El esquema no fue encontrado',
            'nombre.required'    => 'El nombre es requerido',
            'nombre.max'         => 'El nombre supera la longitud permitida',
            'zona_id.required'   => 'La zona es requerida',
            'zona_id.exists'     => 'La zona no fue encontrada',
            'ciudad_id.required' => 'La ciudad de origen es requerida',
            'ciudad_id.exists'   => 'La ciudad de origen no fue encontrada',
        ];
    }
}
