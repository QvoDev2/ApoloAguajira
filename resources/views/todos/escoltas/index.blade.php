@extends('layouts.app')

@section('title')
    Escoltas


    <div class="btn-group float-right" role="group" aria-label="Basic example">
      <a type="button" class="btn btn-primary" href="{{route("{$perfil}.escoltas.create")}}">Nuevo</a>
      <button type="button" btn-importar class="btn btn-success">Importar</button>
    </div>


@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            {!! Form::open(['route' => "{$perfil}.comisiones.exportar", 'method' => 'get', 'id' => 'form_export']) !!}
                <div class="row">
                    <div class="col-sm">
                        {!! Form::label(null, 'Tipo escolta:') !!}
                        {!! Form::select(null, $tiposEscolta, null, $selectFiltro + ['id' => 'tipo_escolta', 'placeholder' => 'Todos']) !!}
                    </div>
                    <div class="col-sm">
                        {!! Form::label(null, 'Nombre:') !!}
                        {!! Form::text(null, null, $inputFiltro + ['id' => 'nombre']) !!}
                    </div>
                    <div class="col-sm">
                        {!! Form::label(null, 'Documento:') !!}
                        {!! Form::text(null, null, $inputFiltro + ['id' => 'documento']) !!}
                    </div>
                    <div class="col-sm">
                        {!! Form::label(null, 'Zona:') !!}
                        {!! Form::select(null, $zonas, null, $selectFiltro + ['id' => 'zona', 'placeholder' => 'Todas']) !!}
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
    @include('todos.escoltas.table')
@endsection

@push('scripts')
    <script type="text/javascript">

      $("[btn-importar]").click(function(){
        let this_ = $(this);
        let input = $('<input/>')
                .attr('type', "file")
                .attr('name', "file")
                .on('change',async function(){
                  let this_ = $(this);
                  let files = await procesararchivos(this_);
                  let url =  `{!! route("{$perfil}.escoltas.importar") !!}`;
                  $.blockUI()
                  await axios.post(url,files).then(resp => {
                    $.unblockUI();
                    Swal.fire('Hecho','Se agregaron los escoltas a la base de datos','success');
                    window.LaravelDataTables['EscoltasTable'].draw();
                    console.log(resp.data);
                  }).catch(err => {
                    $.unblockUI()
                    alert("ERROR:");
                  });
                });
        input.click();
      });

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
