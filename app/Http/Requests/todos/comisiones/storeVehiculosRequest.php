<?php

namespace App\Http\Requests\todos\comisiones;

use Illuminate\Foundation\Http\FormRequest;

class storeVehiculosRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'vehiculos' => 'validar_vehiculos_escoltas'
        ];
    }

    public function messages()
    {
        return [
            'vehiculos.validar_vehiculos_escoltas' => 'Debes seleccionar un vehículo para cada escolta'
        ];
    }
}
