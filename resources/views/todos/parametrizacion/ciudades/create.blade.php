@extends('layouts.app')

@section('title')
    Creando ciudad
@endsection

@section('content')
    {!! Form::open(['route' => "{$perfil}.ciudades.store"]) !!}
        @include('todos.parametrizacion.ciudades.fields')
    {!! Form::close() !!}
@endsection

