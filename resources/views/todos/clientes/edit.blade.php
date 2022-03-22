@extends('layouts.app')

@section('title')
    Editando esquema
@endsection

@section('content')
    {!! Form::model($cliente, ['route' => ["{$perfil}.clientes.update", $cliente->id], 'method' => 'patch']) !!}
        @include('todos.clientes.fields')
    {!! Form::close() !!}
@endsection