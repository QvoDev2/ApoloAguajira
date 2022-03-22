<?php

namespace App\Http\Requests\todos\devoluciones;

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
            'fecha' => 'required',
            'tipo' => 'required',
            'numero' => 'required',
            'observaciones' => 'required|max:450',
        ];
    }

    public function messages()
    {
        return [
            'valor' => 'El valor de la devolución es requerido',
            'fecha' => 'La fecha es requerida',
            'tipo' => 'El tipo de devolución es requerido',
            'numero' => 'El número de devolución es requerido',
            'observaciones.required' => 'Las observaciones son requeridas',
            'observaciones.max' => 'Las observaciones no puede tener más de 450 caracteres',
        ];
    }
}
