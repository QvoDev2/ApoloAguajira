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

    <div class="container datos-devoluciones mt-2">
        <a type="button" class="btn btn-primary text-white float-right" onclick="crearDevolucion()">Nuevo</a><br><br>
        <div id="devolucion-form"></div>
        <table class="table table-striped" id="devolucionesTable">
            <thead>
                <tr>
                    <th>Valor</th>
                    <th>Fecha devolución</th>
                    <th>Tipo</th>
                    <th>Observaciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($comision->devoluciones as $devolucion)
                    <tr>
                        <td>{{ $devolucion->valor }}</td>
                        <td>{{ $devolucion->fecha->format('d/m/Y g:i A') }}</td>
                        <td>{{ $devolucion->tipo }}</td>
                        <td>{{ $devolucion->observaciones }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No hay registros</td>
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
    </script>
@endpush
