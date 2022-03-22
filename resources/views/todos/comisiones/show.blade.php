@extends('layouts.app_modal')

@section('header')
    Comisión - {{ $comisione->numero }}
@endsection

@section('content')
    <style>
        .escolta {
            border: 1px solid #ccc;
            border-radius: 5px;
            margin: 5px;
            font-size: 1.2em;
            border-radius: 5px;
            background-color: #ccc;
            padding: 5px;
        }

    </style>
    <ul class="nav nav-tabs mb-3">
        <li class="nav-item">
            <a class="nav-link tab-adjuntos active" data-target="detalles">Detalles</a>
        </li>
        <li class="nav-item">
            <a class="nav-link tab-adjuntos" data-target="escoltas">Escoltas</a>
        </li>
        <li class="nav-item">
            <a class="nav-link tab-adjuntos" data-target="puntos" id="tab-puntos">Puntos de control</a>
        </li>
        <li class="nav-item">
            <a class="nav-link tab-adjuntos" data-target="novedades" id="tab-novedades">Novedades</a>
        </li>
        <li class="nav-item">
            <a class="nav-link tab-adjuntos" data-target="estados">Estados</a>
        </li>
    </ul>
    <div class="modal fade" id="mapModal" role="dialog" aria-labelledby="mapModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mapModalLabel">Coordenadas reportadas</h5>
                    <button type="button" class="close" onclick="$('#mapModal').modal('hide')">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="app_mapa" style="height: 500px"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="reporteModal" role="dialog" aria-labelledby="reporteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reporteModalLabel">Validación de reporte</h5>
                    <button type="button" class="close" onclick="$('#reporteModal').modal('hide')">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal-reporte"></div>
            </div>
        </div>
    </div>
    <div class="container detalles mt-2">
        <div class="row form-group">
            <div class="col-sm-4">
                <b>Código autorización:</b><br>
                {{ $comisione->numero }}
            </div>
            <div class="col-sm-4">
                <b>Esquema:</b><br>
                {{ $comisione->cliente->nombre }}
            </div>
            <div class="col-sm-4">
                <b>Valor por día:</b><br>
                ${{ number_format($comisione->valor_x_dia, 0) }}
            </div>
        </div>
        <div class="row form-group">
            <div class="col-sm-4">
                <b>Días aprobados:</b><br>
                {{ $comisione->dias_aprobados }}
            </div>
            <div class="col-sm-4">
                <b>Días reales:</b><br>
                {{ $comisione->dias_reales ?? '-' }}
            </div>
            <div class="col-sm-4">
                <b>Valor total:</b><br>
                ${{ number_format($comisione->dias_reales * $comisione->valor_x_dia, 0) }}
            </div>
        </div>
        <div class="row form-group">
            <div class="col-sm-4">
                <b>Fecha aprobación correo:</b><br>
                {{ date('d/m/Y', strtotime($comisione->fecha_aprobacion_correo)) }}
            </div>
            <div class="col-sm-4">
                <b>Fecha inicio:</b><br>
                {{ date('d/m/Y', strtotime($comisione->fecha_inicio)) }}
            </div>
            <div class="col-sm-4">
                <b>Fecha fin:</b><br>
                {{ date('d/m/Y', strtotime($comisione->fecha_fin)) }}
            </div>
        </div>
        <div class="row form-group">
            <div class="col-sm-4">
                <b>Origen:</b><br>
                {{ $comisione->origen ?? '-' }}
            </div>
            <div class="col-sm-4">
                <b>Viajero:</b><br>
                {{ $comisione->viajero ?? '-' }}
            </div>
            <div class="col-sm text-justify">
                <b>Observaciones:</b><br>
                {{ $comisione->observaciones }}
            </div>
        </div>
        <div class="row form-group">
            <div class="col-sm-8">
                <b>Zona:</b><br>
                {{ $comisione->zona->nombre ?? '-' }}
            </div>
            <div class="col-sm-4">
                <b class="text-primary">Noches pernoctadas:</b><br>
                {{ $comisione->noches_pernoctadas ?? '-' }}
            </div>
        </div>
    </div>
    <div class="container escoltas mt-2" style="display: none">
        <div class="row">
            @forelse ($comisione->vehiculosEscoltas()->orderBy('vehiculo_id')->get() as $vehiculoEscolta)
                <div class="col-sm-6">
                    <div class="escolta">
                        <div class="form-row">
                            <div class="col-sm-3">
                                <img src="{{ asset($vehiculoEscolta->escolta->ruta_foto) }}"
                                    class="w-100 rounded-circle">
                            </div>
                            <div class="col-sm-9">
                                {{ $vehiculoEscolta->escolta->nombre_completo }} <br>
                                <small>CC: {{ $vehiculoEscolta->escolta->identificacion }}</small><br>
                                <small>Cód: {{ $vehiculoEscolta->codigo_autorizacion }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
            @endforelse
        </div>
    </div>
    <div class="container puntos mt-2" style="display: none">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Departamento {{ $perfil }}</th>
                    <th>Lugar</th>
                    <th>Coordenadas reportadas</th>
                    @if ($perfil == 'ut' || $perfil == 'admin')
                        <th>Versión</th>
                    @endif
                    <th>Fecha y hora reporte</th>
                    <th>Validación</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($comisione->reportes_ordenados as $reporte)
                    @php
                        $radioMts = $reporte->radioPunto / 1000;
                        $distance = 6371 * acos(cos(deg2rad($reporte->latitud)) * cos(deg2rad($reporte->latPunto)) * cos(deg2rad($reporte->lonPunto) - deg2rad($reporte->longitud)) + sin(deg2rad($reporte->latitud)) * sin(deg2rad($reporte->latPunto)));
                        $classColor = $distance > $radioMts && ($perfil == 'ut' || $perfil == 'admin') ? 'text-red' : 'text-blue';
                    @endphp
                    @if ($reporte->id)
                        <tr>
                            <td>{{ $reporte->departamento->nombre }}</td>
                            <td>{{ $reporte->lugar }}</td>
                            <td>
                                <a onclick="cargarMapa({{ $reporte->latitud_asignacion ?? $reporte->latitud }}, {{ $reporte->longitud_asignacion ?? $reporte->longitud }}, {{ $reporte->precision }})"
                                    class="{{ $classColor }}">
                                    {{ $reporte->latitud_asignacion ?? $reporte->latitud }},
                                    {{ $reporte->longitud_asignacion ?? $reporte->longitud }}
                                </a><br>
                                {{ $reporte->observaciones_fuera_radio }}
                                @if ($perfil == 'ut' || $perfil == 'admin')
                                    <div>
                                        <a href="https://www.google.com/maps/search/{{ $reporte->latitud_asignacion ?? $reporte->latitud }}, {{ $reporte->longitud_asignacion ?? $reporte->longitud }}"
                                            target="_blank">{{ $reporte->editado != 1 && trim($reporte->ubicacion) != '' ? $reporte->ubicacion : 'Ver mapa' }}</a>
                                    </div>
                                @endif
                            </td>
                            @if ($perfil == 'ut' || $perfil == 'admin')
                                <td>
                                    {{ $reporte->version }}
                                </td>
                            @endif
                            <td>
                                {{ $reporte->fecha_reporte->format('d/m/Y g:i A') }}
                            </td>
                            <td>
                                <a onclick="validarReporte({{ $reporte->id }})"
                                    class="btn btn-sm 
                                    @if ($reporte->estado == 'Aprobado') btn-success 
                                    @elseif ($reporte->estado == 'Rechazado') 
                                        btn-danger 
                                    @else 
                                        btn-primary @endif 
                                    text-white"
                                    title="Validación">
                                    <i class="fas fa-laugh-beam" style="font-size: 15px"></i>
                                </a>
                            </td>
                        </tr>
                    @else
                        <tr>
                            <td>{{ $reporte->departamento->nombre }}</td>
                            <td>{{ $reporte->lugar }}</td>
                            <td colspan="{{ $perfil == 'ut' || $perfil == 'admin' ? '4' : '3' }}"></td>
                        </tr>
                    @endif
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No hay puntos de control</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="container novedades mt-2" style="display: none">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Fecha y hora</th>
                    <th>Coordenadas reportadas</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($comisione->reportes_sin_punto as $reporte)
                    <tr>
                        <td>
                            {{ $reporte->fecha_reporte->format('d/m/Y g:i A') }} <br>
                            {{ $reporte->observaciones }}
                        </td>
                        <td>
                            <a onclick="cargarMapa({{ $reporte->latitud }}, {{ $reporte->longitud }}, {{ $reporte->precision }})"
                                class="text-blue">
                                {{ $reporte->latitud }}, {{ $reporte->longitud }}
                            </a>
                        </td>
                        <td>
                            <div class="btn-group">
                                <a class="btn btn-sm btn-primary text-white" title="Asignar"
                                    onclick="cargarModal('{{ route("{$perfil}.reportes.asignar", $reporte->id) }}', 'lg')">
                                    <i class="fa fa-check"></i>
                                </a>
                                <a onclick="validarReporte({{ $reporte->id }})" class="btn btn-sm btn-success text-white"
                                    title="Ver foto">
                                    <i class="fas fa-laugh-beam" style="font-size: 15px"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">No hay novedades</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="container estados mt-2" style="display: none">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Estado</th>
                    <th>Fecha</th>
                    <th>Usuario</th>
                    <th>Observaciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($comisione->estados as $estado)
                    <tr>
                        <td>
                            {{ $estado->estado_texto }}
                            @if ($comisione->estado == App\Models\Comision::ESTADO_FINALIZADO && $estado->estado == App\Models\Comision::ESTADO_FINALIZADO)
                                <a class="btn btn-primary btn-sm text-white float-right" title="Reiniciar"
                                    onclick="confirmarReinicio()">
                                    <i class="fas fa-undo"></i>
                                </a>
                            @endif
                            @if ($comisione->estado == App\Models\Comision::ESTADO_EN_CURSO && $estado->estado == App\Models\Comision::ESTADO_EN_CURSO)
                                <a class="btn btn-primary btn-sm text-white float-right" title="Finalizar"
                                    onclick="confirmarFinalizacion()">
                                    <i class="fa fa-pause"></i>
                                </a>
                            @endif
                        </td>
                        <td>{{ $estado->created_at->format('d/m/Y g:i A') }}</td>
                        <td>{{ $estado->usuario->nombre_completo }}</td>
                        <td>{{ $estado->observaciones ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center"></td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
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
            circle

        $(document).ready(function() {
            map = L.map('app_mapa', {
                layers: [googleRoad],
                zoomControl: false,
                fullscreenControl: true,
                fullscreenControl: {
                    pseudoFullscreen: true
                }
            })

            new L.Control.Zoom({
                position: 'topright'
            }).addTo(map)
            new L.control.layers(baseMaps, {}).addTo(map)

            $('.tab-adjuntos').click(function(e) {
                $('.tab-adjuntos').removeClass('active')
                $('.container').hide()
                $(`.${$(this).data('target')}`).show()
                $(this).addClass('active')
            })

            $('#mapModal').on('shown.bs.modal', function(e) {
                map.invalidateSize()
            }).on('hidden.bs.modal', function(e) {
                map.removeLayer(marker)
                map.removeLayer(circle)
            })
        })

        cargarMapa = (latitud, longitud, precision) => {
            var latlng = new L.LatLng(latitud, longitud)
            marker = L.marker(latlng)
                .addTo(map)
                .bindPopup(`
                    <b>Punto de encuentro</b><br>
                    ${latlng.lat}, ${latlng.lng}
                `)
            circle = L.circle(latlng, precision).addTo(map)
            map.setView(latlng, 11)
            $('#mapModal').modal('show')
        }

        confirmarReinicio = () => {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esta acción!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: '¡Sí, reiniciar!'
            }).then((result) => {
                if (result.value)
                    reinciar()
            })
        }

        confirmarFinalizacion = () => {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esta acción!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: '¡Sí, finalizar!'
            }).then((result) => {
                if (result.value)
                    finalizar()
            })
        }

        reinciar = () => {
            $.blockUI()
            $.ajax({
                type: "patch",
                url: "{{ route("{$perfil}.comisiones.reiniciar", $comisione->id) }}",
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: (res) => {
                    Swal.fire(
                        'Proceso exitoso',
                        res,
                        'success'
                    ).then(() => {
                        $('#ventana').modal('hide')
                        window.LaravelDataTables['ComisionesTable'].draw()
                    })
                },
                error: (res) => {
                    Swal.fire(
                        'Ocurrió un error',
                        res.responseText,
                        'error'
                    )
                }
            }).always(() => {
                $.unblockUI()
            })
        }

        finalizar = () => {
            $.blockUI()
            $.ajax({
                type: "patch",
                url: "{{ route("{$perfil}.comisiones.finalizar", $comisione->id) }}",
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: (res) => {
                    Swal.fire(
                        'Proceso exitoso',
                        res,
                        'success'
                    ).then(() => {
                        $('#ventana').modal('hide')
                        window.LaravelDataTables['ComisionesTable'].draw()
                    })
                },
                error: (res) => {
                    Swal.fire(
                        'Ocurrió un error',
                        res.responseText,
                        'error'
                    )
                }
            }).always(() => {
                $.unblockUI()
            })
        }
    </script>
@endpush
