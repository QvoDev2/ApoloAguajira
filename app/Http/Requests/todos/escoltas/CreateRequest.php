<?php

namespace App\Http\Requests\todos\escoltas;

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
            'tipo_contrato_id'   => 'required|exists:listas,id',
            'tipo_escolta_id'    => 'required|exists:listas,id',
            'identificacion'     => 'required|numeric|digits_between:6,20|unique:escoltas,identificacion',
            'nombre'             => 'required|max:60',
            'apellidos'          => 'required|max:60',
            'email'              => 'required|email|max:80',
            'ciudad_origen'      => 'required|max:100',
            'zonas'              => 'required',
            'celular'            => 'required|numeric|digits:10',
            'estado'             => 'required',
            'imagen'             => 'nullable|image',
            'numero_cuenta'      => 'max:20',
            'banco_id'           => 'required',
            'tipo_cuenta_id'     => 'required',
            'numero_cuenta'      => 'required',
            'empresa_id'         => 'required'
        ];
    }

    public function messages()
    {
        return [
            'tipo_contrato_id.required'     => 'El tipo de contrato es requerido',
            'tipo_contrato_id.exists'       => 'El tipo de contrato no fue encontrado',
            'tipo_escolta_id.required'      => 'El tipo de escolta es requerido',
            'tipo_escolta_id.exists'        => 'El tipo de escolta no fue encontrado',
            'identificacion.required'       => 'La identificación es requerida',
            'identificacion.numeric'        => 'La identificación debe ser un valor numérico',
            'identificacion.digits_between' => 'La identificación no cumple con la longitud permitida',
            'identificacion.unique'         => 'La identificación ya se encuentra registrada en el sistema',
            'nombre.required'               => 'El nombre es requerido',
            'nombre.max'                    => 'El nombre supera la longitud máxima permitida',
            'apellidos.required'            => 'Los apellidos son requeridos',
            'apellidos.max'                 => 'Los apellidos superan la longitud máxima permitida',
            'email.required'                => 'El correo electrónico es requerido',
            'email.email'                   => 'El correo electrónico es inválido',
            'email.max'                     => 'El correo electrónico supera la longitud máxima permitida',
            'ciudad_origen.required'        => 'La ciudad de origen es requerida',
            'ciudad_origen.max'             => 'La ciudad de origen supera la longitud máxima permitida',
            'zonas.required'                => 'Debes seleccionar al menos una zona',
            'celular.required'              => 'El celular es requerido',
            'celular.numeric'               => 'El celular debe ser un valor numérico',
            'celular.digits'                => 'El celular es inválido',
            'estado.required'               => 'El estado es requerido',
            'imagen.image'                  => 'El formato de la foto es inválido',
            'numero_cuenta.max'             => 'La longitud máxima del número de cuenta debe ser de 20 dígitos',
            'banco_id.required'             => 'El banco es requerido',
            'tipo_cuenta_id.required'       => 'El tipo de cuenta es requerido',
            'numero_cuenta.required'        => 'El número de cuenta es requerido',
            'empresa_id.required'           => 'La empresa es requerida'
        ];
    }
}
