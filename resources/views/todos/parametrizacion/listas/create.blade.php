@extends('layouts.app_modal')

@section('header')
    Creando lista
@endsection

@section('content')
    @include('layouts.ajax_errors')
    {!! Form::open(['route' => "{$perfil}.listas.store", 'id' => 'lista-form']) !!}
        @include('todos.parametrizacion.listas.fields')
    {!! Form::close() !!}
@endsection