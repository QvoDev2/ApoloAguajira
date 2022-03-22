@extends('layouts.app')

@section('title')
    Creando vehículo
@endsection

@section('content')
    {!! Form::open(['route' => "{$perfil}.vehiculos.store"]) !!}
        @include('todos.vehiculos.fields')
    {!! Form::close() !!}
@endsection

