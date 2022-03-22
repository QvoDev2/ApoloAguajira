<?php

namespace App\Http\Requests\todos\comisiones;

use Illuminate\Foundation\Http\FormRequest;

class storePuntosRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'departamentos' => 'validar_puntos_comision|array|min:1'
        ];
    }

    public function messages()
    {
        return [
            'departamentos.validar_puntos_comision' => 'Debes ingresar toda la información de los puntos de control',
            'departamentos.array'                   => 'Puntos de control inválidos',
            'departamentos.min'                     => 'Debes ingresar al menos dos puntos de control'
        ];
    }
}
