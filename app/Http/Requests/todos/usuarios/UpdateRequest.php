<?php

namespace App\Http\Requests\todos\usuarios;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'nombres'   => 'required|max:80|min:4',
            'apellidos' => 'required|max:80|min:5',
            'documento' => "required|digits_between:5,15|numeric|unique:users,documento,{$this->id}",
            'celular'   => 'required|digits:10|numeric',
            'email'     => "required|email",
            'perfil_id' => 'required',
            'password'  => 'confirmed|min:8',
            'zonas'     => 'required'
        ];
        if (!$this->password)
            unset($rules['password']);
        return $rules;
    }

    public function messages()
    {
        return [
            'nombres.required'          => 'El nombre es requerido',
            'nombres.max'               => 'Superaste la longitud máxima permitida en el nombre',
            'nombres.min'               => 'El nombre no cumple con la longitud mínima permitida',
    
            'apellidos.required'        => 'Los apellidos son requeridos',
            'apellidos.max'             => 'Superaste la longitud máxima permitida en el campo apellidos',
            'apellidos.min'             => 'El campo apellidos no cumple con la longitud mínima permitida',
    
            'documento.required'        => 'El documento es requerido',
            'documento.digits_between'  => 'El documento ingresado no cumple con la longitud permitida',
            'documento.numeric'         => 'El documento ingresado es inválido (debe ser un valor numérico)',
            'documento.unique'          => 'El documento ingresado ya se encuentra registrado en el sistema',
    
            'celular.required'          => 'El celular ingresado es requerido',
            'celular.digits'            => 'El celular ingresado es inválido',
            'celular.numeric'           => 'El celular ingresado es inválido (debe ser un valor numérico)',
            'celular.unique'            => 'El celular ingresado ya se encuentra registrado en el sistema',
    
            'email.required'            => 'El correo electrónico es requerido',
            'email.email'               => 'El correo ingresado es inválido',
    
            'perfil_id.required'        => 'El perfil es requerido',
    
            'password.confirmed'        => 'No coinciden las contraseñas',
            'password.min'              => 'La contraseña debe ser de mínimo 8 caracteres.',

            'zonas.required'            => 'Debes seleccionar al menos una zona'
        ];
    }
}
