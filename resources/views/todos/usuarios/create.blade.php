@extends('layouts.app')

@section('title')
    Creando usuario
@endsection

@section('content')
    {!! Form::open(['route' => "{$perfil}.usuarios.store"]) !!}
        @include('todos.usuarios.fields')
    {!! Form::close() !!}
@endsection

