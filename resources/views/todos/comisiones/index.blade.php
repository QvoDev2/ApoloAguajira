@extends('layouts.app')

@section('title')
    Comisiones
    <button type="button" class="btn btn-success float-right ml-1" onclick="cargarInstructivoImportar();">Importar</button>
    <a type="button" class="btn btn-primary float-right" href="{{ route("{$perfil}.comisiones.create") }}">Nuevo</a>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h4><span id="SIN_COMPLETAR">0</span></h4>
                    <p>SIN COMPLETAR</p>
                </div>
                <div class="icon">
                    <i class="fas fa-spinner"></i>
                </div>
            </div>
        </div>
        <div class="col-sm">
            <div class="small-box bg-secondary">
                <div class="inner">
                    <h4><span id="ASIGNADO">0</span></h4>
                    <p>ASIGNADO</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
        <div class="col-sm">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h4><span id="EN_CURSO">0</span></h4>
                    <p>EN CURSO</p>
                </div>
                <div class="icon">
                    <i class="fas fa-tasks"></i>
                </div>
            </div>
        </div>
        <div class="col-sm">
            <div class="small-box bg-dark">
                <div class="inner">
                    <h4><span id="CANCELADO">0</span></h4>
                    <p>CANCELADO</p>
                </div>
                <div class="icon">
                    <i class="far fa-times-circle"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h4><span id="FINALIZADO">0</span></h4>
                    <p>FINALIZADO</p>
                </div>
                <div class="icon">
                    <i class="far fa-calendar-check"></i>
                </div>
            </div>
        </div>
        <div class="col-sm">
            <div class="small-box bg-success">
                <div class="inner">
                    <h4><span id="VERIFICADO_UT">0</span></h4>
                    <p>VERIFICADO UT</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-check"></i>
                </div>
            </div>
        </div>
        <div class="col-sm">
            <div class="small-box bg-info">
                <div class="inner">
                    <h4><span id="NOVEDAD">0</span></h4>
                    <p>NOVEDAD</p>
                </div>
                <div class="icon">
                    <i class="far fa-flag"></i>
                </div>
            </div>
        </div>
        <div class="col-sm">
            <div class="small-box bg-success">
                <div class="inner">
                    <h4><span id="APROBADO">0</span></h4>
                    <p>APROBADO UNP</p>
                </div>
                <div class="icon">
                    <i class="fas fa-check"></i>
                </div>
            </div>
        </div>
        <div class="col-sm">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h4><span id="RECHAZADO">0</span></h4>
                    <p>RECHAZADO UNP</p>
                </div>
                <div class="icon">
                    <i class="fas fa-times"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            {!! Form::open(['route' => "{$perfil}.comisiones.exportar", 'method' => 'get', 'id' => 'form_export']) !!}
            <div class="row form-group">
                <div class="col-sm">
                    {!! Form::label(null, 'Escolta:') !!}
                    {!! Form::text('escolta', null, $inputFiltro + ['id' => 'escolta']) !!}
                </div>
                <div class="col-sm">
                    {!! Form::label(null, 'Cod. autorización:') !!}
                    {!! Form::text('comision', null, $inputFiltro + ['id' => 'comision']) !!}
                </div>
                <div class="col-sm">
                    {!! Form::label(null, 'Esquema:') !!}
                    {!! Form::select('cliente', $clientes, null, $selectFiltro + ['id' => 'cliente', 'placeholder' => 'Todos']) !!}
                </div>
                <div class="col-sm">
                    {!! Form::label(null, 'Estado:') !!}
                    {!! Form::select('estado', $estados, null, $selectFiltro + ['id' => 'estado', 'placeholder' => 'Todos']) !!}
                </div>
                <div class="col-sm">
                    {!! Form::label(null, 'Novedades:') !!}
                    {!! Form::select('novedades', ['Con novedades', 'Sin novedades'], null, $selectFiltro + ['id' => 'novedades', 'placeholder' => 'Todos']) !!}
                </div>
                <div class="col-sm">
                    {!! Form::label(null, 'Tipo:') !!}
                    {!! Form::select('tipo', ['Normal', 'Sólo desplazamiento'], null, $selectFiltro + ['id' => 'tipo', 'placeholder' => 'Todos']) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-sm">
                    {!! Form::label(null, 'Desde (inicio comisión):') !!}
                    {!! Form::text('desde_inicio', null, $inputFiltro + ['id' => 'desde_inicio']) !!}
                </div>
                <div class="col-sm">
                    {!! Form::label(null, 'Hasta (inicio comisión):') !!}
                    {!! Form::text('hasta_incio', null, $inputFiltro + ['id' => 'hasta_incio']) !!}
                </div>
                <div class="col-sm">
                    {!! Form::label(null, 'Desde (fin comisión):') !!}
                    {!! Form::text('desde_fin', null, $inputFiltro + ['id' => 'desde_fin']) !!}
                </div>
                <div class="col-sm">
                    {!! Form::label(null, 'Hasta (fin comisión):') !!}
                    {!! Form::text('hasta_fin', null, $inputFiltro + ['id' => 'hasta_fin']) !!}
                </div>
                <div class="col-sm">
                    {!! Form::label(null, 'Zona:') !!}
                    {!! Form::select('zona[]', $zonas, null, $selectFiltroMultiple + ['id' => 'zona', 'class' => 'filtro']) !!}
                </div>
                <div class="col-sm-1">
                    {!! Form::label(null, '&nbsp;') !!} <br>
                    <div class="btn-group" style="margin-left: -10px">
                        <a class="btn btn-primary btn-sm text-white" onclick="filtrar()" title="Filtrar">
                            <i class="fa fa-filter"></i>
                        </a>
                        <a class="btn btn-success btn-sm text-white" onclick="$('#form_export').submit()" title="Exportar">
                            <i class="fas fa-file-excel"></i>
                        </a>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    @include('todos.comisiones.table')
    <div class="modal fade" id="instructivoImportar" data-backdrop="static" data-keyboard="false"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Importar Comisiones</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span
                            aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        {{-- @include('layouts.ajax_errors') --}}
                        <div class="col-12">
                            <ol>
                                <li>Se debe descargar la plantilla, </li>
                                <li>Descargar la plantilla <a
                                        href="{{ route("{$perfil}.comisiones.descargarPlantillaExcel") }}">PlantillaComisiones.xlsx</a>
                                </li>
                                <li>Se debe llenar todas las columnas con los datos correspondientes</li>
                                <li>Adjuntar la plantilla con toda la información diligenciada para el cargue</li>
                            </ol>
                        </div>
                        <div class="col-12">
                            <a href="{{ route("{$perfil}.comisiones.ultimaImportacion") }}">Importaciones pendientes</a>
                        </div>
                        {!! Form::open(['route' => "{$perfil}.comisiones.importar", 'id' => 'FormImportarArmamento', 'class' => 'col-12', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                        {!! Form::label('adjunto', '*Adjunto:', []) !!} <br>
                        {!! Form::file('adjunto', ['id' => 'adjunto', 'class' => 'filestyle']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $("#FormImportarArmamento").ajaxForm({
                success: (r) => {
                    $.unblockUI();
                    $("#adjunto").val('');
                    $("#adjunto").filestyle('clear');
                    Swal.fire('Proceso Exitoso!', r, 'success').then(() => {
                        window.location.href =
                            '{{ route("{$perfil}.comisiones.ultimaImportacion") }}'
                    });
                },
                error: (r) => {
                    $.unblockUI();
                    $("#adjunto").val('');
                    $("#adjunto").filestyle('clear');
                    Swal.fire(
                        'Ha ocurrido un error',
                        r.responseText,
                        'error'
                    )
                }
            });

            $("#adjunto").on('change', function() {
                if ($(this).val() != '') {
                    Swal.fire({
                        title: `¿Importar?`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Importación',
                        cancelButtonText: 'Cancelar',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.blockUI();
                            $("#FormImportarArmamento").submit()
                        } else {
                            $("#adjunto").val('');
                            $("#adjunto").filestyle('clear');
                        }
                    });
                }
            });
        })

        $('#desde_inicio, #hasta_incio').datetimepicker({
            format: 'YYYY-MM-DD'
        }).on('dp.change', function(e) {
            var desde_inicio = new Date($('#desde_inicio').val())
            var hasta_incio = new Date($('#hasta_incio').val())
            if (hasta_incio < desde_inicio)
                $('#hasta_incio').val($('#desde_inicio').val())
        })

        $('#desde_fin, #hasta_fin').datetimepicker({
            format: 'YYYY-MM-DD'
        }).on('dp.change', function(e) {
            var desde_fin = new Date($('#desde_fin').val())
            var hasta_fin = new Date($('#hasta_fin').val())
            if (hasta_fin < desde_fin)
                $('#hasta_fin').val($('#desde_fin').val())
        })

        function verComision(id) {
            cargarModal(`{{ route("{$perfil}.comisiones.show", '') }}/${id}`, 'xl')
        }

        function procesarComision(id, estado, accion, funcion) {
            if (funcion)
                $.globalEval(`${funcion}(${id}, ${estado}, '${accion}')`)
            else
                Swal.fire({
                    title: `¿${accion}?`,
                    html: `
                        <form action="{{ route("{$perfil}.comisiones.procesar", '') }}/${id}" id="form-comision" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-sm-12 form-group">
                                    Ingrese una observación
                                    {!! Form::text('observaciones', null, $input + ['id' => 'observaciones']) !!}
                                </div>
                            </div>
                            <input type="hidden" name="estado" value="${estado}">
                        </form>
                    `,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Cancelar',
                    confirmButtonText: 'Procesar',
                    onRender: ajaxFormProcesar,
                    preConfirm: () => {
                        var observacion = $('#observaciones')
                        if (observacion.val() == '')
                            Swal.showValidationMessage(
                                'Debes ingresar una observación'
                            )
                    },
                }).then((result) => {
                    if (result.value)
                        $('#form-comision').submit()
                })
        }

        function verificarComision(id, estado, accion) {
            $.get(`{{ route("{$perfil}.comisiones.getComision", '') }}/${id}`,
                function(comision, textStatus, jqXHR) {
                    if (textStatus == 'success') {
                        var f = new Intl.NumberFormat()
                        Swal.fire({
                            title: `¿${accion}?`,
                            html: `
                                <b>Días:</b> ${comision.dias_aprobados} &nbsp; <b>Valor:</b> $${f.format(comision.valor_x_dia)} &nbsp; <b>Total:</b> $${f.format(comision.valor_x_dia * comision.dias_aprobados)} <br><br>
                                <form action="{{ route("{$perfil}.comisiones.verificar", '') }}/${id}" id="form-comision" method="post">
                                    @csrf
                                    <div class="form-row form-group">
                                        <div class="col-sm-5">
                                            Días legalizados
                                            <input class="form-control" value="${comision.dias_aprobados}" name="dias_reales" id="dias_reales" onkeyup="this.value=soloNumeros(this.value,true); $('#valor_total').val('$'+new Intl.NumberFormat().format(parseFloat(this.value || 0) * ${comision.valor_x_dia}))">
                                        </div>
                                        <div class="col-sm-7">
                                            Valor total
                                            <input class="form-control" value="$${f.format(comision.valor_x_dia * comision.dias_aprobados)}" id="valor_total" disabled>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-sm-12">
                                            Ingrese una observación
                                            {!! Form::text('observaciones', null, $input + ['id' => 'observaciones']) !!}
                                        </div>
                                    </div>
                                    <input type="hidden" name="estado" value="${estado}">
                                </form>
                            `,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            cancelButtonText: 'Cancelar',
                            confirmButtonText: 'Procesar',
                            onRender: ajaxFormProcesar,
                            preConfirm: () => {
                                var observacion = $('#observaciones').val(),
                                    diasReales = $('#dias_reales').val()
                                if (observacion == '' || diasReales == '')
                                    Swal.showValidationMessage(
                                        'Debes ingresar todos los campos'
                                    )
                            },
                        }).then((result) => {
                            if (result.value)
                                $('#form-comision').submit()
                        })
                    }
                }
            )
        }

        function rechazar(id, estado, accion) {
            Swal.fire({
                title: `¿${accion}?`,
                html: `
                    <form action="{{ route("{$perfil}.comisiones.rechazar", '') }}/${id}" id="form-comision" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12 form-group">
                                Seleccione un motivo de rechazo
                                {!! Form::select('motivo', $motivosRechazo, null, ['id' => 'motivo', 'data-dropup-auto' => 'false', 'class' => 'form-control selectpicker bordered dropup mb-2', 'data-style' => 'form-control', 'data-live-search' => 'true', 'title' => 'Seleccione un motivo']) !!}
                            </div>
                            <div class="col-sm-12 form-group">
                                Ingrese una observación
                                {!! Form::text('observaciones', null, $input + ['id' => 'observaciones']) !!}
                            </div>
                        </div>
                        <input type="hidden" name="estado" value="${estado}">
                    </form>
                `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Procesar',
                onRender: ajaxFormProcesar,
                preConfirm: () => {
                    var motivo = $('#motivo'),
                        observacion = $('#observaciones')
                    if (observacion.val() == '')
                        Swal.showValidationMessage(
                            'Debes ingresar una observación'
                        )
                    if (motivo.val() == '')
                        Swal.showValidationMessage(
                            'Debes seleccionar un motivo de rechazo'
                        )
                },
            }).then((result) => {
                if (result.value)
                    $('#form-comision').submit()
            })
        }

        function adicionarNovedad(id, estado, accion) {
            $.get(`{{ route("{$perfil}.comisiones.getNovedades", '') }}/${id}`,
                function(html, textStatus, jqXHR) {
                    if (textStatus == 'success') {
                        Swal.fire({
                            title: `¿${accion}?`,
                            html: html,
                            icon: 'warning',
                            width: '50%',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            cancelButtonText: 'Cancelar',
                            confirmButtonText: 'Procesar',
                            onRender: ajaxFormProcesar,
                            preConfirm: () => {
                                var observacion = $('#observaciones')
                                if (observacion.val() == '')
                                    Swal.showValidationMessage(
                                        'Debes ingresar una observación'
                                    )
                            },
                        }).then((result) => {
                            if (result.value)
                                $('#form-comision').submit()
                        })
                    }
                }
            )
        }

        function ajaxFormProcesar() {
            $('#motivo').selectpicker()
            $('#form-comision').ajaxForm({
                beforeSubmit: () => {
                    $.blockUI()
                },
                success: (resp) => {
                    Swal.fire(
                        resp,
                        '',
                        'success'
                    )
                },
                error: (resp) => {
                    Swal.fire(
                        'Ha ocurrido un error',
                        resp.responseText,
                        'error'
                    )
                },
                complete: () => {
                    $.unblockUI()
                    window.LaravelDataTables['ComisionesTable'].draw()
                }
            })
        }

        validarReporte = (id) => {
            $.blockUI()
            $('#modal-reporte').load('{{ route("{$perfil}.reportes.show", ':id') }}'.replace(':id', id), function(
                response, status, request) {
                $.unblockUI()
                if (status == 'success')
                    $('#reporteModal').modal('show')
                else
                    Swal.fire(
                        'Ha ocurrido un error',
                        response.responseText,
                        'error'
                    )
            })
        }

        const verPagos = (id) => {
            cargarModal(
                '{{ route("{$perfil}.pagos.index", ':id') }}'.replace(':id', id),
                'xl'
            )
        }

        const cargarInstructivoImportar = () => {
            $("#instructivoImportar").modal('show');
        }
    </script>
@endpush

{{ $scriptConfirmacion }}
