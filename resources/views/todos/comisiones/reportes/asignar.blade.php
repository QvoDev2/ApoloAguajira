@extends('layouts.app_modal')

@section('header')
    Reporte #{{ $reporte->id }}
@endsection

@section('content')
    @include('layouts.ajax_errors')
    {!! Form::model($reporte, ['route' => ["{$perfil}.reportes.guardarAsignacion", $reporte->id], 'id' => 'form-asignacion']) !!}
        {!! Form::hidden('latitud_asignacion', $reporte->latitud, ['id' => 'latitud']) !!}
        {!! Form::hidden('longitud_asignacion', $reporte->longitud, ['id' => 'longitud']) !!}
        {!! Form::hidden('editado', '0', ['id' => 'editado']) !!}
        <div class="row form-group">
            <div class="col-sm-12">
                <div id="app_mapa" style="height: 400px"></div>
            </div>
        </div>
        <div class="form-row form-group">
            <div class="col-sm-12">
                {!! Form::label('punto_control_id', '*Punto de control:', []) !!}
                <select name="punto_control_id" id="punto_control_id" class='form-control selectpicker bordered' data-style='form-control' data-live-search='true' title='Seleccione'>
                    @foreach ($reporte->comision->puntosControl as $punto)
                        <option value="{{ $punto->id }}" data-longitud="{{ $punto->longitud }}" data-latitud="{{ $punto->latitud }}" data-radio="{{ $punto->radio }}">{{ $punto->lugar }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-row d-none" id="observaciones">
            <div class="col-sm-12">
                {!! Form::label('observaciones_fuera_radio', '*Observaciones:', []) !!}
                {!! Form::text('observaciones_fuera_radio', null, $input) !!}
            </div>
        </div>
    {!! Form::close() !!}
@endsection

@section('footer')
    <a class="btn btn-dark text-white" onclick="volver()">
        Regresar
    </a>
    <a class="btn btn-primary text-white" onclick="$('#form-asignacion').submit()">
        Asignar
    </a>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function () {  
            $('#punto_control_id').change((e) => {
                var latitudNovedad = $('#latitud').val(),
                    longitudNovedad = $('#longitud').val(),
                    punto = $('#punto_control_id').find('option:selected'),
                    latitud = punto.data('latitud'),
                    longitud = punto.data('longitud'),
                    radio = punto.data('radio')
                rad = function (x) {
                    return x * Math.PI / 180;
                }
                var R = 6378137, //Radio de la tierra en km
                    dLat = rad(latitudNovedad - latitud),
                    dLong = rad(longitudNovedad - longitud),
                    a = Math.sin(dLat/2) * Math.sin(dLat/2) + Math.cos(rad(latitud)) * Math.cos(rad(latitudNovedad)) * Math.sin(dLong/2) * Math.sin(dLong/2),
                    c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)),
                    d = R * c
                d > radio 
                    ? $('#observaciones').removeClass('d-none') 
                    : $('#observaciones').addClass('d-none')
            })
            
            $('#form-asignacion').ajaxForm({
                beforeSubmit: () => {
                    $.blockUI()
                }, success: (res) => {
                    Swal.fire(
                        'Proceso exitoso',
                        res,
                        'success'
                    ).then(() => {
                        volver()
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
                            volver()
                        })
                }, complete: () => {
                    $.unblockUI()
                }
            })

            $('.selectpicker').selectpicker()
            var mbAttr = '&copy; <a href="https://openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                googleRoad = L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}',{
                    maxZoom: 20,
                    subdomains:['mt0','mt1','mt2','mt3']
                }), 
                googleHybrid = L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}',{
                    maxZoom: 20,
                    subdomains:['mt0','mt1','mt2','mt3']
                }),
                googleSatelite = L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}',{
                    maxZoom: 20,
                    subdomains:['mt0','mt1','mt2','mt3']
                }),
                osm_tile = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: mbAttr }),
                baseMaps = {
                    "Google Maps (Calles)": googleRoad,
                    "Google Maps (Satélite)": googleSatelite,
                    "Google Maps (Híbrido)": googleHybrid,
                    "Open Street Maps": osm_tile
                },
                marker,
                circle,
                latitud = {{ $reporte->latitud }},
                longitud = {{ $reporte->longitud }},
                radio = {{ $reporte->precision }}

            map = L.map('app_mapa', {
                layers: [googleRoad],
                zoomControl: false,
                fullscreenControl: true,
                fullscreenControl: {
                    pseudoFullscreen: true
                }
            }).setView(new L.LatLng(latitud, longitud), 11)
                .on('click', addMarker)

            new L.Control.Zoom({ position: 'topright' }).addTo(map)
            new L.control.layers(baseMaps, {}).addTo(map)
            map.addControl(new L.Control.OSMGeocoder({
                collapsed: true,
                position: 'topleft',
                text: 'Buscar',
                placeholder: 'Ingresa una ubicación'
            }))

            marcarPunto(new L.LatLng(latitud, longitud))

            function addMarker(e)
            {
                @if (auth()->user()->puedeCambiarCoordenadas())
                    if (marker) map.removeLayer(marker)
                    if (circle) map.removeLayer(circle)
                    $('#latitud').val(e.latlng.lat)
                    $('#longitud').val(e.latlng.lng)
                    marcarPunto(e.latlng)
                    $('#editado').val('1')
                @endif
            }
    
            function marcarPunto(latlng)
            {
                marker = L.marker(latlng)
                    .addTo(map)
                    .bindPopup(`
                        <b>Punto de control</b><br>
                        ${latlng.lat}, ${latlng.lng}
                    `)
                circle = L.circle(latlng, radio).addTo(map)
            }
        })

        volver = () => {
            cargarModal('{{ route("{$perfil}.comisiones.show", $reporte->comision->id) }}', 'lg')
            setTimeout(() => { 
                $('#tab-novedades').click()
            }, 1000)
        }
    </script>
@endpush