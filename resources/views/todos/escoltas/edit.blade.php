@extends('layouts.app')

@section('title')
    Editando escolta
@endsection

@section('content')
    {!! Form::model($escolta, ['route' => ["{$perfil}.escoltas.update", $escolta->id], 'method' => 'patch', 'enctype' => 'multipart/form-data']) !!}
        @include('todos.escoltas.fields')
    {!! Form::close() !!}
@endsection
