@extends('layouts.app_modal')

@section('header')
    Editando lista
@endsection

@section('content')
    @include('layouts.ajax_errors')
    {!! Form::model($lista, ['route' => ["{$perfil}.listas.update", $lista->id], 'method' => 'patch', 'id' => 'lista-form']) !!}
        @include('todos.parametrizacion.listas.fields')
    {!! Form::close() !!}
@endsection
