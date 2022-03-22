@extends('layouts.app')

@section('title')
    Vehículos
    <a type="button" class="btn btn-primary float-right" href="{{route("{$perfil}.vehiculos.create")}}">Nuevo</a>
@endsection

@section('content')
    @include('todos.vehiculos.table')
@endsection

{{$scriptConfirmacion}}
