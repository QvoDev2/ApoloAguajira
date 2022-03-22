@extends('layouts.app')

@section('title')
    Creando esquema
@endsection

@section('content')
    {!! Form::open(['route' => "{$perfil}.clientes.store"]) !!}
        @include('todos.clientes.fields')
    {!! Form::close() !!}
@endsection

