@extends('layouts.app')

@section('title')
    Ciudades
    <a type="button" class="btn btn-primary float-right" href="{{route("{$perfil}.ciudades.create")}}">Nuevo</a>
@endsection

@section('content')
    @include('todos.parametrizacion.ciudades.table')
@endsection

{{$scriptConfirmacion}}
