@extends('layouts.app')
@section('title', 'Listas')

@section('content')
    @include('todos.parametrizacion.tipo_listas.table')
@endsection

@push('scripts')
    <script type="text/javascript">
        function verListas(tipo) {
            url = "{{route("{$perfil}.listas.index", ':tipo')}}"
            cargarModal(url.replace(":tipo", tipo), 'xl')
        }
    </script>
@endpush

{{$scriptConfirmacion}}
