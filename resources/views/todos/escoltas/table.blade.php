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
        $('.filtro').change(function (e) {
            filtrar()
        })

        function filtrar() {
            $('#EscoltasTable').on('preXhr.dt', function (e, settings, data) {
                data['tipo_escolta'] = $('#tipo_escolta').val()
                data['nombre'] = $('#nombre').val()
                data['documento'] = $('#documento').val()
                data['zona'] = $('#zona').val()
            })
            window.LaravelDataTables["EscoltasTable"].draw()
        }
    </script>
@endpush
