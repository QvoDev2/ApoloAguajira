@extends('layouts.app')

@section('title')
    Creando escolta
@endsection

@section('content')
    {!! Form::open(['route' => "{$perfil}.escoltas.store", 'enctype' => 'multipart/form-data']) !!}
        @include('todos.escoltas.fields')
    {!! Form::close() !!}
@endsection

