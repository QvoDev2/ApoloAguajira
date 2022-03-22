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
        $(document).keypress((e) => {
            e.keyCode === 13 && filtrar()
        })

        $('.filtro').change(function(e) {
            filtrar()
        }).on('dp.change', function(e) {
            filtrar()
        })

        function filtrar() {
            $('#ComisionesTable').on('preXhr.dt', function(e, settings, data) {
                var filtros = [
                    'zona',
                    'escolta',
                    'comision',
                    'cliente',
                    'estado',
                    'desde_inicio',
                    'hasta_incio',
                    'desde_fin',
                    'hasta_fin',
                    'tipo',
                    'novedades'
                ]
                $.each(filtros, function(i, v) {
                    data[v] = $(`#${v}`).val()
                })
            })
            window.LaravelDataTables["ComisionesTable"].draw()
        }
    </script>
@endpush
