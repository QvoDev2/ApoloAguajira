@extends('layouts.app')

@section('title')
    Editando vehículo
@endsection

@section('content')
    {!! Form::model($vehiculo, ['route' => ["{$perfil}.vehiculos.update", $vehiculo->id], 'method' => 'patch']) !!}
        @include('todos.vehiculos.fields')
    {!! Form::close() !!}
@endsection


