@extends('layouts.app')

@section('title')
    Usuarios
    <a type="button" class="btn btn-primary float-right" href="{{route("{$perfil}.usuarios.create")}}">Nuevo</a>
@endsection

@section('content')
    <div class="alert alert-danger alert-dismissible fade show d-none" role="alert" id="alert">
        Ha ocurrido un error.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="card">
        <div class="card-body">
            {!! Form::open(['route' => "{$perfil}.comisiones.exportar", 'method' => 'get', 'id' => 'form_export']) !!}
                <div class="row">
                    <div class="col-sm">
                        {!! Form::label(null, 'Nombre:') !!}
                        {!! Form::text(null, null, $inputFiltro + ['id' => 'nombre']) !!}
                    </div>
                    <div class="col-sm">
                        {!! Form::label(null, 'Documento:') !!}
                        {!! Form::text(null, null, $inputFiltro + ['id' => 'documento']) !!}
                    </div>
                    <div class="col-sm">
                        {!! Form::label(null, 'Perfiles:') !!}
                        {!! Form::select(null, $perfiles, null, $selectFiltro + ['id' => 'perfil', 'placeholder' => 'Todos']) !!}
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
    @include('todos.usuarios.table')
@endsection

@push('scripts')
    <script type="text/javascript">
        confirmarRestablecerContrasena = (id) => {
            Swal.fire({
                title: '¿Restablecer contraseña?',
                text: "¡No podrás revertir esta acción!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: '¡Sí, restablecer!'
            }).then((result) => {
                if (result.value) {
                    $.blockUI()
                    restablecerContrasena(id)
                }
            })
        }

        restablecerContrasena = (id) => {
            $.ajax({
                type: "POST",
                url: '{{route("{$perfil}.usuarios.actualizarClave", ':id')}}'.replace(':id', id),
                data: {
                    _method: 'PATCH',
                    _token: '{{csrf_token()}}'
                },
                success: function (r) {
                    Swal.fire(
                        'Hecho',
                        r,
                        'success'
                    )
                },
                error: function (r) {
                    Swal.fire(
                        'Ha ocurrido un error',
                        r.responseText,
                        'error'
                    )
                }
            }).always(() => {
                $.unblockUI()
            })
        }
    </script>
@endpush

{{$scriptConfirmacion}}
