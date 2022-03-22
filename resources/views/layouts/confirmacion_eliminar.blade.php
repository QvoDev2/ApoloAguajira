@push('scripts')
    <script type="text/javascript">
        async function confirmar(form, ajax, callback) {
            if (ajax)
                await ajaxForm(form, callback)
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
                    $.blockUI()
                    $(form).submit()
                }
            })
        }

        function ajaxForm(form, callback) {
            $(form).ajaxForm({
                success: function (r) {
                    $.unblockUI()
                    Swal.fire(
                        'Hecho',
                        r,
                        'success'
                    ).then(callback)
                },
                error: function (r) {
                    $.unblockUI()
                    Swal.fire(
                        'Ha ocurrido un error',
                        r.responseText,
                        'error'
                    )
                }
            })
        }
    </script>
@endpush
