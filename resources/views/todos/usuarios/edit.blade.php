@extends('layouts.app')

@section('title')
    Editando usuario
@endsection

@section('content')
    {!! Form::model($usuario, ['route' => ["{$perfil}.usuarios.update", $usuario->id], 'method' => 'patch']) !!}
        @include('todos.usuarios.fields')
    {!! Form::close() !!}
@endsection


