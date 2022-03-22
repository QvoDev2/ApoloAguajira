@extends('layouts.app_modal')

@section('header')
    Parametrización listas
@endsection

@section('title')
    <h1>
        {{ $label }}
        <button type="button" class="btn btn-primary float-right" onclick="crear({{$id}})">Nuevo</button>
    </h1>
@endsection

@section('content')
    @include('todos.parametrizacion.listas.table')
@endsection

@push('scripts')
    <script type="text/javascript">
        function crear(id) {
            url = "{{route("{$perfil}.listas.create", ':id')}}"
            cargarModal(url.replace(":id", id), 'md')
        }

        function editar(id) {
            url = "{{route("{$perfil}.listas.edit", ':id')}}";
            cargarModal(url.replace(":id", id), 'md')
        }
    </script>
@endpush
