<?php

namespace App\Http\Requests\todos\ciudades;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'departamento_id'   => 'required',
            'nombre'            => 'required|max:45',
            'longitud'          => 'required|numeric',
            'latitud'           => 'required|numeric',
            'radio'             => 'required|numeric|digits_between:1,7',
        ];
    }

    public function messages()
    {
        return [
            'departamento_id.required'  => 'El departamento es requerido',
            'nombre.required'           => 'El nombre es requerido',
            'nombre.max'                => 'El nombre supera la longitud máxima',
            'longitud.required'         => 'La longitud es requerida',
            'latitud.required'          => 'La latitud es requerida',
            'radio.required'            => 'El radio es requerido'
        ];
    }
}
