@extends('layouts.app')

@section('title')
    Creando comisión
@endsection

@section('content')
    <style>
        .borde {
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        #lista1, #lista2 {
            width: 100%;
            min-height: 20px;
            list-style-type: none;
            padding: 5px 0 0 0;
        }

        #lista1>li, #lista2>li {
            margin: 5px;
            font-size: 1.2em;
            border-radius: 5px;
            background-color: #ccc;
            padding: 5px;
        }

        #lista1>li.oculto {
            display: none;
        }
    </style> 
    @include('todos.comisiones.steps', ['step' => $comision->paso_creacion])
    @include('layouts.ajax_errors')
    <div class="row">
        <div class="col-sm ml-2">
            <div class="form-row">
                <div class="col-sm-11">
                    <input class="form-control form-control-sm" type="text" placeholder="Ingresa nombre o documento" id="filtro">
                </div>
                <div class="col-sm-1">
                    <a class="btn btn-sm btn-primary text-white" onclick="buscar()">
                        <i class="fa fa-search"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-sm-1"></div>
        <div class="col-sm"></div>
    </div>
    <div class="row m-2">
        <div class="col-sm borde form-group">
            <i class="text-muted">
                *Personal asignado al esquema*
                <span class="float-right">
                    {!! Form::checkbox(null, null, null, ['id' => 'ver_todos', 'style' => 'margin-top: 5px']) !!} 
                    Ver todos
                </span>
            </i>
            <ol id="lista1" class="lista"></ol>
        </div>

        <div class="col-sm-1 text-center text-white">
            <a onclick="seleccionar()" class="btn btn-primary" style="width: 100%; height: 23px; padding: 0; margin-top: 10px">
                <i class="fas fa-long-arrow-alt-right"></i>
            </a>
            <a onclick="deseleccionar()" class="btn btn-primary" style="width: 100%; height: 23px; padding: 0; margin-top: 10px">
                <i class="fas fa-long-arrow-alt-left"></i>
            </a>
        </div>

        <div class="col-sm borde form-group">
            <i class="text-muted">*Escoltas seleccionados*</i>
            <ol id="lista2" class="lista h-100"></ol>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-sm-12 text-right">
            {!! Form::button('Guardar', ['class' => 'btn btn-primary', 'onclick' => 'guardar()']) !!}
            <a href="{{route("{$perfil}.comisiones.index")}}" class="btn btn-secondary">Cancelar</a>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(function () {
            buscar()
            $("#lista1, #lista2").sortable({
                connectWith: ".lista",
                cursor: "move",
                revert: true,
                receive: function(event, ui) {
                    $(`#e${$(ui.item).data('id')}`).toggle()
                }
            }).disableSelection()
            $('#ver_todos').change(function (e) {
                if ($(this).prop('checked'))
                    $('.disponible').removeClass('oculto')
                else
                    $('.disponible').addClass('oculto')
                filtrar()
            })
        })

        function seleccionar()
        {
            $($('#lista1').children('li:not(.oculto)')).each(function (i, e) {
                $(e).appendTo('#lista2')
                $('#lista2').sortable('option', 'receive')(null, { item: $(e) })
            })
        }

        function deseleccionar()
        {
            $($('#lista2').children('li')).each(function (i, e) {
                $(e).appendTo('#lista1')
                $('#lista1').sortable('option', 'receive')(null, { item: $(e) })
            })
        }

        function guardar()
        {
            $.blockUI()
            var escoltas = []
            $('#lista2>li').each(function (i, e) {
                escoltas.push({
                    escolta_id: $(this).data('id'),
                    codigo_autorizacion: $(this).find('input').val()                 
                })
            })
            $.ajax({
                type: "post",
                url: "{{ route("{$perfil}.comisiones.storeEscoltas", $comision->id) }}",
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
                        window.location.href = '{{ route("{$perfil}.comisiones.continuar", $comision->id) }}'
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
                            window.location.href = '{{ route("{$perfil}.comisiones.continuar", $comision->id) }}'
                        })
                }
            }).always(() => {
                $.unblockUI()
            })
        }

        function filtrar()
        {
            var filtro = $('#filtro').val().toLowerCase()
            $('#lista1>li:not(.disponible.oculto)').each(function (index, element) {
                if ($(element).find('.info').html().toLowerCase().includes(filtro))
                    $(element).removeClass('oculto')
            })
            $('#lista1>li').each(function (index, element) {
                if (!$(element).find('.info').html().toLowerCase().includes(filtro))
                    $(element).addClass('oculto')
            })
        }

        buscar = () => {
            $.blockUI()
            var escoltas = []
            $('#lista2>li').each(function(i, e) {
                escoltas.push($(this).data('id'));
            })
            $('#lista1').load(
                "{{ route("{$perfil}.comisiones.getEscoltasDisponibles", $comision->cliente_id) }}", {
                    escoltas: escoltas,
                    filtro: $('#filtro').val(),
                    _method: 'get',
                    _token: '{{ csrf_token() }}'
                },
                function(response, status, request) {
                    $('#ver_todos').prop('checked', false)
                    $.unblockUI()
                }
            );
        }
    </script>
@endpush