@extends('layouts.app_modal')

@section('header')
    Comisión - {{ $comision->numero }}
@endsection

@section('content')
    <ul class="nav nav-tabs mb-3">
        <li class="nav-item">
            <a class="nav-link tab-pagos active" data-target="datos-pagos">Pagos</a>
        </li>
        <li class="nav-item">
            <a class="nav-link tab-pagos" data-target="datos-devoluciones">Devoluciones</a>
        </li>
    </ul>

    <div class="container datos-pagos mt-2">
        <a type="button" class="btn btn-primary text-white float-right" onclick="crearPago()">Nuevo</a><br><br>
        <div id="pago-form"></div>
        @include('todos.pagos.table')
    </div>

    <div class="container datos-devoluciones mt-2" style="display: none">
        <a type="button" class="btn btn-primary text-white float-right" onclick="crearDevolucion()">Nuevo</a><br><br>
        <div id="devolucion-form"></div>
        <table class="table table-striped" id="devoluciones_table">
            <thead>
                <tr>
                    <th>Valor</th>
                    <th>Fecha devolución</th>
                    <th>Tipo</th>
                    <th>Observaciones</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($comision->devoluciones as $devolucion)
                    <tr>
                        <td>{{ $devolucion->valor }}</td>
                        <td>{{ $devolucion->fecha->format('d/m/Y') }}</td>
                        <td>{{ $devolucion->tipo }}</td>
                        <td>{{ $devolucion->observaciones }}</td>
                        <td>
                            <div class='btn-group'>
                                <a onclick="editarDevolucion({{ $devolucion->id }})"
                                    class="btn btn-primary btn-sm text-white" data-toggle="tooltip" title="Editar">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <button class="btn btn-danger btn-sm eliminar" data-toggle="tooltip" title="Eliminar"
                                    onclick="eliminarDevolucion({{ $devolucion->id }})" type="button">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Ningún dato disponible en esta tabla</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.tab-pagos').click(function(e) {
                $('.tab-pagos').removeClass('active')
                $('.container').hide()
                $(`.${$(this).data('target')}`).show()
                $(this).addClass('active')
            })
        })

        crearPago = () => {
            $.blockUI()
            $('#pago-form').load(
                '{{ route("{$perfil}.pagos.create", $comision->id) }}',
                (response, status, request) => {
                    if (status == 'error')
                        Swal.fire(
                            'Ocurrió un error',
                            response,
                            'error'
                        )
                    $.unblockUI()
                }
            )
        }

        editarPago = (id) => {
            $.blockUI()
            $('#pago-form').load(
                '{{ route("{$perfil}.pagos.edit", ':id') }}'.replace(":id", id),
                (response, status, request) => {
                    if (status == 'error')
                        Swal.fire(
                            'Ocurrió un error',
                            response,
                            'error'
                        )
                    $.unblockUI()
                }
            )
        }

        crearDevolucion = () => {
            $.blockUI()
            $('#devolucion-form').load(
                '{{ route("{$perfil}.devoluciones.create", $comision->id) }}',
                (response, status, request) => {
                    if (status == 'error')
                        Swal.fire(
                            'Ocurrió un error',
                            response,
                            'error'
                        )
                    $.unblockUI()
                }
            )
        }

        editarDevolucion = (id) => {
            $.blockUI()
            $('#devolucion-form').load(
                '{{ route("{$perfil}.devoluciones.edit", ':id') }}'.replace(':id', id),
                (response, status, request) => {
                    if (status == 'error')
                        Swal.fire(
                            'Ocurrió un error',
                            response,
                            'error'
                        )
                    $.unblockUI()
                }
            )
        }

        eliminarDevolucion = (id) => {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esta acción!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: '¡Sí, eliminar!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: '{{ route("{$perfil}.devoluciones.destroy", ':id') }}'.replace(':id',
                            id),
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        method: 'DELETE',
                        success: function(r) {
                            cargarTabla();
                        }
                    });
                }
            })

        }

        cargarTabla = () => {
            $.ajax({
                url: '{{ route("{$perfil}.devoluciones.getDatos", $comision->id) }}',
                method: 'GET',
                success: function(r) {
                    let lista = r;
                    let htmlCode = ``;
                    $.each(lista, function(index, item) {
                        htmlCode += `<tr>
                                <td>${item.valor}</td>
                                <td>${item.fecha_n}</td>
                                <td>${item.tipo}</td>
                                <td>${item.observaciones}</td>
                                <td>
                                    <div class='btn-group'>
                                        <a onclick="editarDevolucion(${item.id})"
                                            class="btn btn-primary btn-sm text-white" data-toggle="tooltip" title="Editar">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <button class="btn btn-danger btn-sm eliminar" data-toggle="tooltip" title="Eliminar"
                                            onclick="eliminarDevolucion(${item.id})" type="button">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>`;
                    });
                    $('#devoluciones_table tbody').html(htmlCode);
                }
            });
        }
    </script>
@endpush
