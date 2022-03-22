<?php

namespace App\Http\Requests\todos\esquemas_seguridad;

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
            'escoltas' => 'validar_esquema'
        ];
    }

    public function messages()
    {
        return [
            'escoltas.validar_esquema'  => 'Debes seleccionar la fecha de vinculación de todos los escoltas'
        ];
    }
}
