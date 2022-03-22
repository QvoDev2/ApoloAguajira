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
            $('#ClientesTable').on('preXhr.dt', function (e, settings, data) {
                data['nombre'] = $('#nombre').val()
                data['zona'] = $('#zona').val()
            })
            window.LaravelDataTables["ClientesTable"].draw()
        }
    </script>
@endpush
