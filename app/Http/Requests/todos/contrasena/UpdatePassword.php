<?php

namespace App\Http\Requests\todos\contrasena;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePassword extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'current_password'  => 'required|current_password',
            'password'          => 'confirmed|min:8',
        ];
    }

    public function messages()
    {
        return [
            'current_password.required'         => 'Debes ingresar tu contraseña actual.',
            'current_password.current_password' => 'La contraseña ingresada no coincide con tu contraseña actual.',

            'password.confirmed'                => 'No coinciden las contraseñas.',
            'password.min'                      => 'La contraseña nueva debe tener mínimo 8 caracteres.'
        ];
    }
}
