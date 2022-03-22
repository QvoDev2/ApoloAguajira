@if ($reporte->fotos_novedades)
    <ul class="nav nav-tabs mb-3">
        <li class="nav-item">
            <a class="nav-link tab-validacion active" data-target="reporte">Reporte</a>
        </li>
        <li class="nav-item">
            <a class="nav-link tab-validacion" data-target="novedades2">Novedades</a>
        </li>
    </ul>
@endif

<div class="container2 reporte mt-2">
    <div class="row form-group">
        <div class="col-sm-6">
            <b>Foto escolta:</b><br>
            <img src="{{ asset($reporte->comision->escolta->ruta_foto) }}" class="img-thumbnail w-100 mt-2">
        </div>
        <div class="col-sm-6">
            <b>Foto reporte:</b><br>
            <img src="{{ asset($reporte->ruta_foto) }}" class="img-thumbnail w-100 mt-2">
        </div>
    </div>
    @if ($reporte->observaciones_rechazo)
        <div class="row form-group">
            <div class="col-sm-12">
                <b>Observaciones:</b><br>
                {{ $reporte->observaciones_rechazo }}
            </div>
        </div>
    @endif
    @if (!$reporte->estado && $reporte->punto_control_id)
        <hr>
        <div class="form-row">
            <div class="col-sm-3 offset-6">
                <a class="btn btn-block btn-success text-white" onclick="aprobarFoto()">
                    <i class="fa fa-check"></i>
                    Aprobar
                </a>
            </div>
            <div class="col-sm-3">
                <a class="btn btn-block btn-danger text-white" onclick="rechazarFoto()">
                    <i class="fa fa-times"></i>
                    Rechazar
                </a>
            </div>
        </div>    
    @endif
</div>

<div class="container2 novedades2 mt-2" style="display: none">
    <div class="row">
        @foreach ($reporte->fotos_novedades ?? [] as $foto)
            <div class="col-sm">
                <img src="{{ asset("storage/reportes_puntos/{$reporte->id}/novedades/{$foto}") }}" class="img-thumbnail w-100 mt-2">
            </div>
        @endforeach
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('.tab-validacion').click(function (e) {
            $('.tab-validacion').removeClass('active')
            $('.container2').hide()
            $(`.${$(this).data('target')}`).show()
            $(this).addClass('active')
        })
    })

    aprobarFoto = () => {
        Swal.fire({
            title: `¿Aprobar foto?`,
            html: `
                <form action="{{ route("{$perfil}.reportes.aprobar", $reporte->id) }}" id="form-aprobar" class="ajaxForm" method="post">
                    @csrf
                </form>
            `,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Aprobar',
            onRender: ajaxForm
        }).then((result) => {
            if (result.value) 
                $('#form-aprobar').submit()
        })
    }

    rechazarFoto = () => {
        Swal.fire({
            title: `¿Rechazar foto?`,
            html: `
                <form action="{{ route("{$perfil}.reportes.rechazar", $reporte->id) }}" id="form-rechazar" class="ajaxForm" method="post">
                    @csrf
                    <div class="row form-group">
                        <div class="col-sm-12">
                            Ingrese una observación
                            {!! Form::text('observaciones', null, $input + ['id' => 'observaciones']) !!}
                        </div>
                    </div>
                </form>
            `,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Rechazar',
            onRender: ajaxForm,
            preConfirm: () => {
                var observacion = $('#observaciones').val()
                if(observacion == '')
                    Swal.showValidationMessage(
                        'Debes ingresar una observación'
                    )
            }
        }).then((result) => {
            if (result.value) 
                $('#form-rechazar').submit()
        })
    }

    ajaxForm = () => {
        $('.ajaxForm').ajaxForm({
            beforeSubmit: () => {
                $.blockUI()
            },
            success: (res) => {
                Swal.fire(
                    res,
                    '',
                    'success'
                )
                $('#reporteModal').modal('hide')
                setTimeout(() => {
                    verComision({{ $reporte->comision->id }})
                    setTimeout(() => {
                        $('#tab-puntos').click()
                    }, 1000)
                }, 100)
            }, error: (resp) => {
                Swal.fire(
                    'Ha ocurrido un error',
                    resp.responseText,
                    'error'
                )
            }, complete: () => {
                $.unblockUI()
            }
        })
    }
</script>