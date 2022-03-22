@extends('layouts.app')

@section('title')
    Editando ciudad
@endsection

@section('content')
    {!! Form::model($ciudad, ['route' => ["{$perfil}.ciudades.update", $ciudad->id], 'method' => 'patch']) !!}
        @include('todos.parametrizacion.ciudades.fields')
    {!! Form::close() !!}
@endsection


