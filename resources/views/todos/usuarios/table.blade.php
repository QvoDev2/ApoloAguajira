@section('css')
    @include('layouts.datatables_css')
@endsection

<div class="table-responsive">
    {!! $dataTable->table(['width' => '100%']) !!}
</div>

@push('scripts')
    @include('layouts.datatables_js')
    {!! $dataTable->scripts() !!}
    <script type="text/javascript">
        function cambiarEstado(id)
        {
            url = '{{route("{$perfil}.usuarios.cambiar-estado", ':id')}}'
            url = url.replace(':id', id)

            $.ajax({
                type: "POST",
                url: url,
                data: {
                    _method: 'PATCH',
                    _token: '{{csrf_token()}}'
                },
                error: function (res) {
                    $('#alert').removeClass('d-none')
                },
            })

            window.LaravelDataTables["UsuariosTable"].draw()
        }

        $('.filtro').change(function (e) {
            filtrar()
        })

        function filtrar() {
            $('#UsuariosTable').on('preXhr.dt', function (e, settings, data) {
                data['nombre'] = $('#nombre').val()
                data['documento'] = $('#documento').val()
                data['perfil'] = $('#perfil').val()
            })
            window.LaravelDataTables["UsuariosTable"].draw()
        }
    </script>
@endpush
