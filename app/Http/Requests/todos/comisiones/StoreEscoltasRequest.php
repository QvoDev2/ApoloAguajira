<?php

namespace App\Http\Requests\todos\comisiones;

use Illuminate\Foundation\Http\FormRequest;

class StoreEscoltasRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'escoltas' => 'required|validar_escoltas_comision|codigo_autorizacion|numero_comision'
        ];
    }

    public function messages()
    {
        return [
            'escoltas.required'                   => 'Debes adicionar al menos un escolta',
            'escoltas.validar_escoltas_comision'  => 'Debes ingresar el códido de autorización de todos los escoltas',
            'escoltas.codigo_autorizacion'        => 'Uno de los códigos ya se encuentra registrado',
            'escoltas.numero_comision'            => 'El código de autorización debe ser de 13 o 14 dígitos'
        ];
    }
}
