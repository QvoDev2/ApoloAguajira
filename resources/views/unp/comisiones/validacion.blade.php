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
</script>