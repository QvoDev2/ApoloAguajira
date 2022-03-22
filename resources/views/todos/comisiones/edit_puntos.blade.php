@extends('layouts.app')

@section('title')
    Editando comisión
@endsection

@section('content')
    @include('todos.comisiones.steps_edit', ['step' => 2, 'id' => $comision->id])
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
                    {!! Form::text(null, 0, $input + ['id'=> 'radio-modal', 'onkeyup' => "PUNTO.find(`input[name='radios[]']`).val(this.value); circle.setRadius(this.value)"]) !!} <br>
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
                    <div class="col-sm">
                        {!! Form::label('departamentos[]', '*Departamento:') !!}
                        {!! Form::select('departamentos[]', $departamentos, $punto->departamento_id, $select + ['onchange' => 'cargarCoordenadas($(this).closest("div.form-row"))']) !!}
                    </div>
                    <div class="col-sm">
                        {!! Form::label('lugares[]', '*Lugar:') !!}
                        {!! Form::text('lugares[]', $punto->lugar, $input + ['onchange' => 'cargarCoordenadas($(this).closest("div.form-row"))']) !!}
                    </div>
                    <div class="col-sm">
                        {!! Form::label('latitudes[]', '*Latitud:') !!}
                        {!! Form::text('latitudes[]', $punto->latitud, $input + ['readonly']) !!}
                    </div>
                    <div class="col-sm">
                        {!! Form::label('longitudes[]', '*Longitud:') !!}
                        {!! Form::text('longitudes[]', $punto->longitud, $input + ['readonly']) !!}
                    </div>
                    <div class="col-sm">
                        {!! Form::label('radios[]', '*Radio:') !!}
                        {!! Form::text('radios[]', $punto->radio, $input + ['onchange' => 'if(!this.value) $(this).val(0)']) !!}
                    </div>
                    <div class="col-sm-1">
                        <div class="btn-group" style="margin-top: 35px">
                            <a class="btn btn-primary text-white btn-sm" title="Agregar coordenadas" onclick="cargarMapa($(this).closest('div.form-row'))">
                                <i class="fas fa-location-arrow"></i>
                            </a>
                        </div>
                    </div>
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
        $('#mapModal').on('shown.bs.modal', function (e) {
            map.invalidateSize()
        }).on('hidden.bs.modal', function (e) {
            map.removeLayer(marker)
            map.removeLayer(circle)
        })

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
        new L.Control.Zoom({ position: 'topright' }).addTo(map)
        new L.control.layers(baseMaps, {}).addTo(map)
        map.addControl(new L.Control.OSMGeocoder({
            collapsed: true,
            position: 'topleft',
            text: 'Buscar',
            placeholder: 'Ingresa una ubicación'
        }))

        map.on('click', addMarker)

        function addMarker(e)
        {
            if (marker) map.removeLayer(marker)
            if (circle) map.removeLayer(circle)
            var radioSelector = PUNTO.find('input[name="radios[]"]'),
                radio = parseInt(radioSelector.val() || minRadio)
            PUNTO.find('input[name="latitudes[]"]').val(e.latlng.lat)
            PUNTO.find('input[name="longitudes[]"]').val(e.latlng.lng)
            radioSelector.val(radio)
            marcarPunto(e.latlng, radio)
        }

        function marcarPunto(latlng, radio)
        {
            marker = L.marker(latlng)
                .addTo(map)
                .bindPopup(`
                    <b>Punto de control</b><br>
                    ${latlng.lat}, ${latlng.lng}
                `)
            circle = L.circle(latlng, radio).addTo(map)
        }

        function cargarMapa(selector)
        {
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

        function agregarPunto()
        {
            $('#puntos').append(`
                <div class="form-row form-group">
                    <div class="col-sm">
                        {!! Form::label('departamentos[]', '*Departamento:') !!}
                        {!! Form::select('departamentos[]', $departamentos, null, $select + ['onchange' => 'cargarCoordenadas($(this).closest("div.form-row"))']) !!}
                    </div>
                    <div class="col-sm">
                        {!! Form::label('lugares[]', '*Lugar:') !!}
                        {!! Form::text('lugares[]', null, $input + ['onchange' => 'cargarCoordenadas($(this).closest("div.form-row"))']) !!}
                    </div>
                    <div class="col-sm">
                        {!! Form::label('latitudes[]', '*Latitud:') !!}
                        {!! Form::text('latitudes[]', null, $input + ['readonly']) !!}
                    </div>
                    <div class="col-sm">
                        {!! Form::label('longitudes[]', '*Longitud:') !!}
                        {!! Form::text('longitudes[]', null, $input + ['readonly']) !!}
                    </div>
                    <div class="col-sm">
                        {!! Form::label('radios[]', '*Radio:') !!}
                        {!! Form::text('radios[]', 2000, $input + []) !!}
                    </div>
                    <div class="col-sm-1">
                        <div class="btn-group" style="margin-top: 35px">
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
                        PUNTO.find('input[name="latitudes[]"]').val(res.latitud)
                        PUNTO.find('input[name="longitudes[]"]').val(res.longitud)
                        PUNTO.find('input[name="radios[]"]').val(res.radio || 2000)
                    }
                )
            }
        }
    </script>
@endpush