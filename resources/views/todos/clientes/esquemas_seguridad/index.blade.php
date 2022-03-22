@extends('layouts.app_modal')

@section('header')
    Esquema de seguridad - {{ $cliente->nombre }}
@endsection

@section('content')
    <style>
        .borde {
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        #lista1,
        #lista2 {
            width: 100%;
            min-height: 20px;
            list-style-type: none;
            padding: 5px 0 0 0;
        }

        #lista1>li,
        #lista2>li {
            margin: 5px;
            font-size: 1.2em;
            border-radius: 5px;
            background-color: #ccc;
            padding: 5px;
        }

    </style>
    @include('layouts.ajax_errors')
    <div class="row">
        <div class="col-sm ml-2">
            <div class="form-row">
                <div class="col-sm-10">
                    <input class="form-control form-control-sm" type="text" placeholder="Ingresa nombre o documento"
                        id="filtro">
                </div>
                <div class="col-sm-2">
                    <a class="btn btn-sm btn-primary text-white" onclick="filtrar()">
                        <i class="fa fa-search"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-sm mr-2">
            <a class="btn btn-sm btn-primary text-white float-right" onclick="guardar()">
                Guardar
            </a>
        </div>
    </div>

    <div class="row m-2">
        <div class="col-sm borde">
            <i class="text-muted">*Escoltas disponibles*</i>
            <ol id="lista1" class="lista h-100"></ol>
        </div>

        <div class="col-sm-1 text-center text-white">
            <a onclick="seleccionar()" class="btn btn-primary"
                style="width: 100%; height: 23px; padding: 0; margin-top: 10px">
                <i class="fas fa-long-arrow-alt-right"></i>
            </a>
        </div>

        <div class="col-sm borde">
            <i class="text-muted">
                *Escoltas seleccionados*
            </i>
            <ol id="lista2" class="lista h-100">
                @forelse ($cliente->escoltas as $escolta)
                    <li data-id="{{ $escolta->id }}" data-estado="{{ $escolta->estado }}" class="
                                @if ($escolta->pivot->fecha_retiro) oculto
                    @elseif (!$escolta->estado && !$escolta->pivot->fecha_retiro)
                        oculto inactivo @endif
                        ">
                        <div class="form-row">
                            <div class="col-sm-3">
                                <img src="{{ asset($escolta->ruta_foto) }}" class="w-100 rounded-circle">
                            </div>
                            <div class="col-sm-9">
                                {{ $escolta->nombre_completo }} <br>
                                <small>{{ $escolta->identificacion }}</small>
                            </div>
                        </div>
                        <div id="e{{ $escolta->id }}" class="mt-1">
                            {!! Form::text(null, $escolta->pivot->fecha_vinculacion, ['placeholder' => 'Fecha vinculación', 'class' => 'form-control datetimepicker vinculacion']) !!}
                            {!! Form::text(null, $escolta->pivot->fecha_retiro, ['placeholder' => 'Fecha retiro', 'class' => 'form-control datetimepicker retiro']) !!}
                        </div>
                    </li>
                @empty
                @endforelse
            </ol>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(function() {
            $('.datetimepicker').datetimepicker({
                format: 'YYYY-MM-DD'
            })
            filtrar()
            $("#lista1, #lista2").sortable({
                connectWith: ".lista",
                cursor: "move",
                revert: true,
                receive: function(event, ui) {
                    $(`#e${$(ui.item).data('id')}`).toggle()
                }
            }).disableSelection()
            $('#ver_todos').change(function(e) {
                if ($(this).prop('checked'))
                    $('.oculto').show()
                else
                    $('.oculto').hide()
            })
        })

        function seleccionar() {
            $($('#lista1').children('li')).each(function(i, e) {
                $(e).appendTo('#lista2')
                $('#lista2').sortable('option', 'receive')(null, {
                    item: $(e)
                })
            })
        }

        function deseleccionar() {
            $($('#lista2').children('li')).each(function(i, e) {
                $(e).appendTo('#lista1')
                $('#lista1').sortable('option', 'receive')(null, {
                    item: $(e)
                })
            })
        }

        function guardar() {
            $.blockUI()
            var escoltas = []
            $('#lista2>li').each(function(i, e) {
                escoltas.push({
                    id: $(this).data('id'),
                    vinculacion: $(this).find('input.vinculacion').val(),
                    retiro: $(this).find('input.retiro').val()
                })
            })
            $.ajax({
                type: "post",
                url: "{{ route("{$perfil}.esquema.update", $cliente->id) }}",
                data: {
                    _token: '{{ csrf_token() }}',
                    escoltas: escoltas
                },
                success: (res) => {
                    Swal.fire(
                        'Proceso exitoso',
                        res,
                        'success'
                    ).then(() => {
                        $('#ventana').modal('hide')
                    })
                },
                error: (res) => {
                    if (res.status == 422)
                        mostrarErroresAjax(res)
                    else
                        Swal.fire(
                            'Ocurrió un error',
                            res.responseText,
                            'error'
                        ).then(() => {
                            gestionarEsquema({{ $cliente->id }})
                        })
                }
            }).always(() => {
                $.unblockUI()
            })
        }

        filtrar = () => {
            $.blockUI()
            var escoltas = []
            $('#lista2>li').each(function(i, e) {
                escoltas.push($(this).data('id'));
            })
            $('#lista1').load(
                "{{ route("{$perfil}.esquema.getEscoltasDisponibles", $cliente->id) }}", {
                    escoltas: escoltas,
                    filtro: $('#filtro').val(),
                    _method: 'get',
                    _token: '{{ csrf_token() }}'
                },
                function(response, status, request) {
                    $.unblockUI()
                }
            );
        }
    </script>
@endpush
