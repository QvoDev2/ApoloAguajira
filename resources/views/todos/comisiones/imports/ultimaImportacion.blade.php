@extends('layouts.app')

@section('title')
    Importaciones pendientes
@endsection

@section('content')
    @include('layouts.ajax_errors')
    <div class="modal fade" id="mapModal" tabindex="-1" role="dialog" aria-labelledby="mapModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mapModalLabel">Agregar coordenadas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {!! Form::label(null, 'Radio:') !!}
                    {!! Form::text(null, 0, $input + ['id' => 'radio-modal', 'onkeyup' => "PUNTO.find(`input[name='radios[]']`).val(this.value); circle.setRadius(this.value)"]) !!} <br>
                    <div id="app_mapa" style="height: 400px"></div>
                </div>
                <div class="modal-footer">
                    <a class="float-right btn btn-primary text-white" data-dismiss="modal" aria-label="Close">
                        Confirmar
                    </a>
                </div>
            </div>
        </div>
    </div>
    {{-- <h3 class="text-center font-weight-bold">Comisiones sin completar</h3> --}}
    @forelse ($imports as $import)
        @php
            if($import->comision->paso_creacion == 0) continue;
            $puntos = $import->comision->puntosControl()->get();
        @endphp
        <div id="row_{{ $import->comision_id }}">
            <h5 class="font-weight-bold">Comisión - {{ $import->numero }}</h5>
            {!! Form::open(['route' => ["{$perfil}.comisiones.storePuntosImport", $import->comision_id], 'id' => 'form-puntos_' . $import->comision_id, 'class' => 'row form-puntos']) !!}
            <div class="col-sm-1">
                {!! Form::label(null, '&nbsp;') !!} <br>
                <a class="btn btn-success btn-block text-white" title="Agregar punto de control"
                    onclick="agregarPunto({{ $import->comision_id }})">
                    <i class="fa fa-plus"></i>
                </a>
            </div>
            <div class="col-sm-11" id="puntos_{{ $import->comision_id }}">
                <div>
                    Datos de importación: <br>{{ !empty($import->destinos->lugar) ? $import->destinos->lugar : '' }}
                </div>
                <hr>
                @if (count($puntos) > 0)
                    @foreach ($puntos as $index => $punto)
                        <div class="form-row form-group">
                            <div class="col-sm">
                                @if ($index == 0)
                                    {!! Form::label('departamentos[]', '*Departamento:') !!}
                                @endif
                                {!! Form::select('departamentos[]', $departamentos, $punto->departamento_id, $select + ['onchange' => 'cargarCoordenadas($(this).closest("div.form-row"))']) !!}
                            </div>
                            <div class="col-sm">
                                @if ($index == 0)
                                    {!! Form::label('lugares[]', '*Lugar:') !!}
                                @endif
                                {!! Form::text('lugares[]', $punto->lugar, $input + ['onchange' => 'cargarCoordenadas($(this).closest("div.form-row"))']) !!}
                            </div>
                            <div class="col-sm">
                                @if ($index == 0)
                                    {!! Form::label('latitudes[]', '*Latitud:') !!}
                                @endif
                                {!! Form::text('latitudes[]', $punto->latitud, $input + ['readonly']) !!}
                            </div>
                            <div class="col-sm">
                                @if ($index == 0)
                                    {!! Form::label('longitudes[]', '*Longitud:') !!}
                                @endif
                                {!! Form::text('longitudes[]', $punto->longitud, $input + ['readonly']) !!}
                            </div>
                            <div class="col-sm">
                                @if ($index == 0)
                                    {!! Form::label('radios[]', '*Radio:') !!}
                                @endif
                                {!! Form::text('radios[]', $punto->radio, $input + ['onchange' => 'if(!this.value) $(this).val(0)']) !!}
                            </div>
                            <div class="col-sm-1 align-self-end">
                                <div class="btn-group">
                                    <a class="btn btn-primary text-white btn-sm" title="Agregar coordenadas"
                                        onclick="cargarMapa($(this).closest('div.form-row'))">
                                        <i class="fas fa-location-arrow"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
                <div class="form-row form-group">
                    <div class="col-sm">
                        @if (!count($puntos) > 0)
                            {!! Form::label('departamentos[]', '*Departamento:') !!}
                        @endif
                        {!! Form::select('departamentos[]', $departamentos, null, $select + ['onchange' => 'cargarCoordenadas($(this).closest("div.form-row"))']) !!}
                    </div>
                    <div class="col-sm">
                        @if (!count($puntos) > 0)
                            {!! Form::label('lugares[]', '*Lugar:') !!}
                        @endif
                        {!! Form::text('lugares[]', null, $input + ['onchange' => 'cargarCoordenadas($(this).closest("div.form-row"))']) !!}
                    </div>
                    <div class="col-sm">
                        @if (!count($puntos) > 0)
                            {!! Form::label('latitudes[]', '*Latitud:') !!}
                        @endif
                        {!! Form::text('latitudes[]', null, $input + ['readonly']) !!}
                    </div>
                    <div class="col-sm">
                        @if (!count($puntos) > 0)
                            {!! Form::label('longitudes[]', '*Longitud:') !!}
                        @endif
                        {!! Form::text('longitudes[]', null, $input + ['readonly']) !!}
                    </div>
                    <div class="col-sm">
                        @if (!count($puntos) > 0)
                            {!! Form::label('radios[]', '*Radio:') !!}
                        @endif
                        {!! Form::text('radios[]', 2000, $input + ['onchange' => 'if(!this.value) $(this).val(0)']) !!}
                    </div>
                    <div class="col-sm-1 align-self-end">
                        <div class="btn-group">
                            <a class="btn btn-primary text-white btn-sm" title="Agregar coordenadas"
                                onclick="cargarMapa($(this).closest('div.form-row'))">
                                <i class="fas fa-location-arrow"></i>
                            </a>
                            <a class="btn btn-danger text-white btn-sm" title="Eliminar punto de control"
                                onclick="$(this).closest('div.form-row').remove()">
                                <i class="fa fa-minus"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
            <div class="row">
                <div class="form-group col-sm-12 text-right">
                    {!! Form::button('<i class="fas fa-check"></i> Confirmar', ['class' => 'btn btn-success', 'onclick' => '$("#form-puntos_' . $import->comision_id . '").submit()']) !!}
                </div>
            </div>
        </div>
    @empty
        <div class="text-center">
            <p>No hay registros, todas las comisiones se importaron correctamente.</p>
        </div>
    @endforelse
@endsection

@push('scripts')
    <script type="text/javascript">
        $('#mapModal').on('shown.bs.modal', function(e) {
            map.invalidateSize()
        }).on('hidden.bs.modal', function(e) {
            map.removeLayer(marker)
            map.removeLayer(circle)
        })

        $('.form-puntos').ajaxForm({
            beforeSubmit: () => {
                $.blockUI()
            },
            success: (res) => {
                Swal.fire(
                    'Proceso exitoso',
                    res.msg,
                    'success'
                ).then(() => {
                    $('#row_' + res.comision_id).remove();
                    $("#errores").addClass("d-none");
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

                    })
            },
            complete: () => {
                $.unblockUI()
            }
        })

        var mbAttr = '&copy; <a href="https://openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            googleRoad = L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
            }),
            googleHybrid = L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
            }),
            googleSatelite = L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
            }),
            osm_tile = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: mbAttr
            }),
            baseMaps = {
                "Google Maps (Calles)": googleRoad,
                "Google Maps (Satélite)": googleSatelite,
                "Google Maps (Híbrido)": googleHybrid,
                "Open Street Maps": osm_tile
            },
            marker,
            circle,
            defLat = 4.665833212401183,
            defLng = -74.0938724266277,
            defZoom = 11,
            minRadio = 0
        map = L.map('app_mapa', {
            layers: [googleRoad],
            zoomControl: false,
            fullscreenControl: true,
            fullscreenControl: {
                pseudoFullscreen: true
            }
        }).setView(new L.LatLng(defLat, defLng), defZoom)
        new L.Control.Zoom({
            position: 'topright'
        }).addTo(map)
        new L.control.layers(baseMaps, {}).addTo(map)
        map.addControl(new L.Control.OSMGeocoder({
            collapsed: true,
            position: 'topleft',
            text: 'Buscar',
            placeholder: 'Ingresa una ubicación'
        }))

        map.on('click', addMarker)

        function addMarker(e) {
            if (marker) map.removeLayer(marker)
            if (circle) map.removeLayer(circle)
            var radioSelector = PUNTO.find('input[name="radios[]"]'),
                radio = parseInt(radioSelector.val() || minRadio)
            PUNTO.find('input[name="latitudes[]"]').val(e.latlng.lat)
            PUNTO.find('input[name="longitudes[]"]').val(e.latlng.lng)
            radioSelector.val(radio)
            marcarPunto(e.latlng, radio)
        }

        function marcarPunto(latlng, radio) {
            marker = L.marker(latlng)
                .addTo(map)
                .bindPopup(`
                    <b>Punto de control</b><br>
                    ${latlng.lat}, ${latlng.lng}
                `)
            circle = L.circle(latlng, radio).addTo(map)
        }

        function cargarMapa(selector) {
            PUNTO = selector
            var latitud = parseFloat(PUNTO.find('input[name="latitudes[]"]').val()),
                longitud = parseFloat(PUNTO.find('input[name="longitudes[]"]').val()),
                radio = parseInt(PUNTO.find('input[name="radios[]"]').val())
            if (!isNaN(latitud) && !isNaN(longitud)) {
                marcarPunto(new L.LatLng(latitud, longitud), radio || minRadio)
                map.setView(new L.LatLng(latitud, longitud), defZoom)
            } else
                map.setView(new L.LatLng(defLat, defLng), defZoom)
            $('#radio-modal').val(radio)
            $('#mapModal').modal('show')
        }

        function cargarCoordenadas(selector) {
            PUNTO = selector
            var departamento = PUNTO.find('select[name="departamentos[]"]').val(),
                lugar = PUNTO.find('input[name="lugares[]"]').val()
            if (departamento && lugar) {
                $.blockUI()
                $.get('{{ route("{$perfil}.comisiones.getCoordenadas") }}', {
                        departamento: departamento,
                        lugar: lugar
                    },
                    function(res, textStatus, jqXHR) {
                        $.unblockUI()
                        PUNTO.find('input[name="latitudes[]"]').val(res.latitud)
                        PUNTO.find('input[name="longitudes[]"]').val(res.longitud)
                        PUNTO.find('input[name="radios[]"]').val(res.radio || 2000)
                    }
                )
            }
        }

        function agregarPunto(comisionId) {
            $('#puntos_' + comisionId).append(`
                <div class="form-row form-group">
                    <div class="col-sm">
                        {!! Form::select('departamentos[]', $departamentos, null, $select + ['onchange' => 'cargarCoordenadas($(this).closest("div.form-row"))']) !!}
                    </div>
                    <div class="col-sm">
                        {!! Form::text('lugares[]', null, $input + ['onchange' => 'cargarCoordenadas($(this).closest("div.form-row"))']) !!}
                    </div>
                    <div class="col-sm">
                        {!! Form::text('latitudes[]', null, $input + ['readonly']) !!}
                    </div>
                    <div class="col-sm">
                        {!! Form::text('longitudes[]', null, $input + ['readonly']) !!}
                    </div>
                    <div class="col-sm">
                        {!! Form::text('radios[]', 2000, $input + []) !!}
                    </div>
                    <div class="col-sm-1 align-self-end">
                        <div class="btn-group">
                            <a class="btn btn-primary text-white btn-sm" title="Agregar coordenadas" onclick="cargarMapa($(this).closest('div.form-row'))">
                                <i class="fas fa-location-arrow"></i>
                            </a>
                            <a class="btn btn-danger text-white btn-sm" title="Eliminar punto de control" onclick="$(this).closest('div.form-row').remove()">
                                <i class="fa fa-minus"></i>
                            </a>
                        </div>
                    </div>
                </div>
            `)
            $('.selectpicker').selectpicker()
        }
    </script>
@endpush
