@include('layouts.errors')
{!! Form::hidden('id', null, []) !!}
<div class="row-ciudad">
    <div class="row">
        <div class="form-group col-sm-4">
            {!! Form::label('departamento_id', '*Departamento:') !!}
            {!! Form::select('departamento_id', $departamentos, null, $select) !!}
        </div>
        <div class="form-group col-sm-4">
            {!! Form::label('nombre', '*Nombre:') !!}
            {!! Form::text('nombre', null, $input) !!}
        </div>
        <div class="form-group col-sm-4">
            {!! Form::label('radio', '*Radio:') !!}
            {!! Form::text('radio', $ciudad->radio ?? 2000, $input + ['onchange' => 'if(!this.value) $(this).val(0)']) !!}
        </div>
    </div>
    <div class="row">
        <div class="form-group col-sm-4">
            {!! Form::label('longitud', '*Longitud:') !!}
            {!! Form::text('longitud', null, $input + ['readonly']) !!}
        </div>
        <div class="form-group col-sm-4">
            {!! Form::label('latitud', '*Latitud:') !!}
            {!! Form::text('latitud', null, $input + ['readonly']) !!}
        </div>
        <div class="form-group col-sm-4 align-self-end">
            <div class="btn-group">
                <a class="btn btn-primary text-white btn-sm" title="Agregar coordenadas"
                    onclick="cargarMapa($(this).closest('div.row-ciudad'))">
                    <i class="fas fa-location-arrow"></i>
                </a>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="form-group col-sm-12 text-right">
        {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
        <a href="{{ route("{$perfil}.ciudades.index") }}" class="btn btn-secondary">Cancelar</a>
    </div>
</div>

<div class="modal fade" id="mapModal" tabindex="-1" role="dialog" aria-labelledby="mapModalLabel"
    aria-hidden="true">
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
                {!! Form::text(null, 0, $input + ['id' => 'radio-modal', 'onkeyup' => "PUNTO.find(`input[name='radio']`).val(this.value); circle.setRadius(this.value)"]) !!} <br>
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

@push('scripts')
    <script type="text/javascript">
        $('#mapModal').on('shown.bs.modal', function(e) {
            map.invalidateSize()
        }).on('hidden.bs.modal', function(e) {
            map.removeLayer(marker)
            map.removeLayer(circle)
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
            var radioSelector = PUNTO.find('input[name="radio"]'),
                radio = parseInt(radioSelector.val() || minRadio)
            PUNTO.find('input[name="latitud"]').val(e.latlng.lat)
            PUNTO.find('input[name="longitud"]').val(e.latlng.lng)
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
            var latitud = parseFloat(PUNTO.find('input[name="latitud"]').val()),
                longitud = parseFloat(PUNTO.find('input[name="longitud"]').val()),
                radio = parseInt(PUNTO.find('input[name="radio"]').val())
            if (!isNaN(latitud) && !isNaN(longitud)) {
                marcarPunto(new L.LatLng(latitud, longitud), radio || minRadio)
                map.setView(new L.LatLng(latitud, longitud), defZoom)
            } else
                map.setView(new L.LatLng(defLat, defLng), defZoom)
            $('#radio-modal').val(radio)
            $('#mapModal').modal('show')
        }
    </script>
@endpush
