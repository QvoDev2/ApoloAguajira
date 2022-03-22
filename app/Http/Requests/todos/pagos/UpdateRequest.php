<?php

namespace App\Http\Requests\todos\pagos;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'valor' => 'required',
            'codigo' => 'required',
            'fecha_corte' => 'required',
            'fecha_pago' => 'required',
            'observaciones' => 'max:450',
        ];
    }

    public function messages()
    {
        return [
            'valor' => 'El valor del pago es requerido',
            'codigo' => 'El código del pago es requerida',
            'fecha_corte' => 'La fecha de corte es requerida',
            'fecha_pago' => 'La fecha de pago es requerida',
            'observaciones.max' => 'Las observaciones no puede tener más de 450 caracteres',
        ];
    }
}
