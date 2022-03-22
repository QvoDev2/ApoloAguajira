<?php

namespace App\Http\Requests\todos\reportes;

use Illuminate\Foundation\Http\FormRequest;

class AsignacionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'longitud_asignacion'       => 'required',
            'latitud_asignacion'        => 'required',
            'editado'                   => 'required',
            'punto_control_id'          => 'required|exists:puntos_control,id',
            'observaciones_fuera_radio' => 'coordenadas_asignacion'
        ];
    }

    public function messages()
    {
        return [
            'longitud_asignacion.required'                     => 'Ocurrió un error cargando la longitud',
            'latitud_asignacion.required'                      => 'Ocurrió un error cargando la latitud',
            'editado.required'                                 => 'Ocurrió un error cargando información',
            'punto_control_id.required'                        => 'Debes seleccionar un punto de control',
            'punto_control_id.exists'                          => 'El punto de control no fue encontrado',
            'observaciones_fuera_radio.coordenadas_asignacion' => 'Las observaciones son requeridas'
        ];
    }
}
