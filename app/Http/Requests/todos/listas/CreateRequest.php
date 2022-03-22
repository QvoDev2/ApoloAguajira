<?php

namespace App\Http\Requests\todos\listas;

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
            'codigo'        => 'nullable|max:50',
            'nombre'        => 'required|max:50',
            'descripcion'   => 'nullable|max:500',
            'lista_id'      => 'nullable|exists:listas,id',
            'tipo_lista_id' => 'nullable|exists:tipo_listas,id',
        ];
    }

    public function messages()
    {
        return [
            'tipo_lista_id.exists'  => 'Ha ocurrido un error cargando el tipo de lista',
            'codigo.max'            => 'El código supera la longitud máxima',
            'nombre.required'       => 'El nombre es requerido',
            'nombre.max'            => 'El código supera la longitud máxima',
            'descripcion.max'       => 'La descripción supera la longitud máxima',
            'lista_id.exists'       => 'El valor seleccionado en "Pertenece a" no fue encontrado',
        ];
    }
}
