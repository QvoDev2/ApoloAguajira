@extends('layouts.app')

@section('title')
    Esquemas
    <a type="button" class="btn btn-primary float-right" href="{{route("{$perfil}.clientes.create")}}">Nuevo</a>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            {!! Form::open(['route' => "{$perfil}.comisiones.exportar", 'method' => 'get', 'id' => 'form_export']) !!}
                <div class="row">
                    <div class="col-sm">
                        {!! Form::label(null, 'Nombre:') !!}
                        {!! Form::text(null, null, $inputFiltro + ['id' => 'nombre']) !!}
                    </div>
                    <div class="col-sm">
                        {!! Form::label(null, 'Zona:') !!}
                        {!! Form::select(null, $zonas, null, $selectFiltro + ['id' => 'zona', 'placeholder' => 'Todas']) !!}
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
    @include('todos.clientes.table')
@endsection

@push('scripts')
    <script type="text/javascript">
        function gestionarEsquema(id)
        {
            cargarModal(`{{route("{$perfil}.esquema.index", '')}}/${id}`, 'lg')
        }
    </script>
@endpush

{{$scriptConfirmacion}}
