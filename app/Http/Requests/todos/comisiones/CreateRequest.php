<?php

namespace App\Http\Requests\todos\comisiones;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
            'fecha_aprobacion_correo' => 'required',
            'fecha_inicio'            => 'required',
            'fecha_fin'               => 'required',
            'tipo'                    => 'required',
            'cliente_id'              => 'required|exists:clientes,id',
            'valor_x_dia'             => 'required|numeric|digits_between:1,8',
            'dias_aprobados'          => 'required|numeric|max:99.9',
            'departamento_id'         => 'required|exists:listas,id',
            'origen'                  => 'required|max:100',
            'tipo_desplazamiento_id'  => 'required|exists:listas,id',
            'viajero'                 => 'nullable|max:100'
        ];
    }

    public function messages()
    {
        return [
            'cliente_id.required'               => 'El esquema es requerido',
            'cliente_id.exists'                 => 'El esquema no fue encontrado',
            'valor_x_dia.required'              => 'El valor por día es requerido',
            'valor_x_dia.numeric'               => 'El valor por día debe ser numérico',
            'valor_x_dia.digits_between'        => 'El valor por día supera la longitud permitida',
            'fecha_aprobacion_correo.required'  => 'La fecha de aprobación es requerida',
            'fecha_inicio.required'             => 'La fecha de inicio es requerida',
            'fecha_fin.required'                => 'La fecha de finalización es requerida',
            'tipo.required'                     => 'El tipo es requerido',
            'dias_aprobados.required'           => 'Los días aprobados son requeridos',
            'dias_aprobados.numeric'            => 'Los días aprobados deben ser numéricos',
            'dias_aprobados.max'                => 'Los días aprobados no cumplen con la longitud permitida',
            'departamento_id.required'          => 'El departamento es requerido',
            'departamento_id.required'          => 'El departamento no fue encontrado',
            'origen.required'                   => 'El origen es requerido',
            'origen.max'                        => 'El origen supera la longitud permitida',
            'tipo_desplazamiento_id.required'   => 'El medio de desplazamiento es requerido',
            'tipo_desplazamiento_id.max'        => 'El medio de desplazamiento supera la longitud permitida',
            'viajero.max'                       => 'El viajero supera la longitud permitida'
        ];
    }
}
