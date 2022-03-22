@extends('layouts.app')

@section('title')
    Editando comisión
@endsection

@section('content')
    @include('todos.comisiones.steps_edit', ['step' => 2, 'id' => $comision->id])
    @include('layouts.ajax_errors')
    {!! Form::open(['route' => ["{$perfil}.comisiones.updatePuntos", $comision->id], 'id' => 'form-puntos', 'class' => 'row', 'method' => 'patch']) !!}
        <div class="col-sm-1">
            {!! Form::label(null, '&nbsp;') !!} <br>
            <a class="btn btn-success btn-block text-white" title="Agregar punto de control" onclick="agregarPunto()">
                <i class="fa fa-plus"></i>
            </a>
        </div>
        <div class="col-sm-11" id="puntos">
            @foreach ($comision->puntosControl as $punto)
                {!! Form::hidden('ids[]', $punto->id, []) !!}
                <div class="form-row form-group">
                    {!! Form::hidden('latitudes[]', $punto->latitud, $input + ['readonly']) !!}
                    {!! Form::hidden('longitudes[]', $punto->longitud, $input + ['readonly']) !!}
                    {!! Form::hidden('radios[]', $punto->radio, $input + []) !!}
                    <div class="col-sm">
                        {!! Form::label('departamentos[]', '*Departamento:') !!}
                        {!! Form::select('departamentos[]', $departamentos, $punto->departamento_id, $select + ['onchange' => 'cargarCoordenadas($(this).closest("div.form-row"))']) !!}
                    </div>
                    <div class="col-sm">
                        {!! Form::label('lugares[]', '*Lugar:') !!}
                        {!! Form::text('lugares[]', $punto->lugar, $input + ['onchange' => 'cargarCoordenadas($(this).closest("div.form-row"))']) !!}
                    </div>
                    <div class="col-sm-1"></div>
                </div>
            @endforeach
        </div>
    {!! Form::close() !!}
    <div class="row">
        <div class="col-sm-12 text-right">
            {!! Form::button('Guardar', ['class' => 'btn btn-primary', 'onclick' => '$("#form-puntos").submit()']) !!}
            <a href="{{route("{$perfil}.comisiones.index")}}" class="btn btn-secondary">Cancelar</a>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $('#form-puntos').ajaxForm({
            beforeSubmit: () => {
                $.blockUI()
            }, success: (res) => {
                Swal.fire(
                    'Proceso exitoso',
                    res,
                    'success'
                ).then(() => {
                    window.location.href = '{{ route("{$perfil}.comisiones.index") }}'
                })
            }, error: (res) => {
                if(res.status == 422)
                    mostrarErroresAjax(res)
                else
                    Swal.fire(
                        'Ocurrió un error',
                        res.responseText,
                        'error'
                    ).then(() => {
                        window.location.href = '{{ route("{$perfil}.comisiones.index") }}'
                    })
            }, complete: () => {
                $.unblockUI()
            }
        })

        function agregarPunto()
        {
            $('#puntos').append(`
                <div class="form-row form-group">
                    {!! Form::hidden('latitudes[]', null, $input + ['readonly']) !!}
                    {!! Form::hidden('longitudes[]', null, $input + ['readonly']) !!}
                    {!! Form::hidden('radios[]', 2000, $input + []) !!}
                    <div class="col-sm">
                        {!! Form::label('departamentos[]', '*Departamento:') !!}
                        {!! Form::select('departamentos[]', $departamentos, null, $select + ['onchange' => 'cargarCoordenadas($(this).closest("div.form-row"))']) !!}
                    </div>
                    <div class="col-sm">
                        {!! Form::label('lugares[]', '*Lugar:') !!}
                        {!! Form::text('lugares[]', null, $input + ['onchange' => 'cargarCoordenadas($(this).closest("div.form-row"))']) !!}
                    </div>
                    <div class="col-sm-1">
                        <div class="btn-group" style="margin-top: 35px">
                            <a class="btn btn-danger text-white btn-sm" title="Eliminar punto de control" onclick="$(this).closest('div.form-row').remove()">
                                <i class="fa fa-minus"></i>
                            </a>
                        </div>
                    </div>
                </div>
            `)
            $('.selectpicker').selectpicker()
        }

        function cargarCoordenadas(selector)
        {
            PUNTO = selector
            var departamento = PUNTO.find('select[name="departamentos[]"]').val(),
                lugar = PUNTO.find('input[name="lugares[]"]').val()
            if (departamento && lugar) {
                $.blockUI()
                $.get('{{ route("{$perfil}.comisiones.getCoordenadas") }}', 
                    {
                        departamento: departamento,
                        lugar: lugar
                    },
                    function (res, textStatus, jqXHR) {
                        $.unblockUI()
                        if (!res.latitud || !res.longitud || !res.radio)
                            Swal.fire('Este destino no está creado', '', 'warning')
                        else {
                            PUNTO.find('input[name="latitudes[]"]').val(res.latitud)
                            PUNTO.find('input[name="longitudes[]"]').val(res.longitud)
                            PUNTO.find('input[name="radios[]"]').val(res.radio)
                        }
                    }
                )
            }
        }
    </script>
@endpush