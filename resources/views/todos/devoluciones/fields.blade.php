@include('layouts.ajax_errors')

<div class="row">
    <div class="form-group col-sm-3">
        {!! Form::label('valor', '*Valor:') !!}
        {!! Form::number('valor', null, ['maxlength' => '9', 'class' => 'form-control']) !!}
    </div>
    <div class="form-group col-sm-2">
        {!! Form::label('fecha', '*Fecha devolución:') !!}
        {!! Form::text('fecha', null, $datetimepicker) !!}
    </div>
    <div class="form-group col-sm-2">
        {!! Form::label('tipo', '*Tipo devolución:') !!}
        {!! Form::select('tipo', $tipos, null, $select + ['data-container' => 'body']) !!}
    </div>
    <div class="form-group col-sm-2">
        {!! Form::label('numero', '*Número:') !!}
        {!! Form::text('numero', null, ['maxlength' => '50', 'class' => 'form-control']) !!}
    </div>
    <div class="form-group col-sm-3">
        {!! Form::label('observaciones', '*Observaciones:') !!}
        {!! Form::textarea('observaciones', null, ['maxlength' => '450', 'class' => 'form-control', 'rows' => '3']) !!}
    </div>
</div>
<div class="row">
    <div class="form-group col-sm-4">
        {!! Form::label('imagen', 'Imagen:') !!}
        @if (!empty($imagenes[2]) && !empty($devolucion))
            {{ $imagenes[2] }}
            <a class="btn btn-primary btn-sm text-white" title="Foto" data-toggle="modal" data-target="#fotoModal">
                <i class="fa fa-picture-o" aria-hidden="true"></i>
            </a>
        @endif
        {!! Form::file('imagen', ['id' => 'imagen', 'class' => 'filestyle', 'accept' => 'image/png, image/jpeg']) !!}
    </div>
</div>
<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="fotoModal" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Imagen</h5>
                <button type="button" class="close" onclick="closeModal()" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                @if (!empty($imagenes[2]) && !empty($devolucion))
                    <img src="{{ asset('storage/devoluciones/imagenes/' . $devolucion->id . '/' . $imagenes[2]) }}">
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal()">Cerrar</button>
                @if (!empty($imagenes[2]) && !empty($devolucion))
                    <a href="{{ route('admin.devoluciones.downloadFile', $devolucion->id) }}"><button type="button"
                            class="btn btn-primary">Descargar</button></a>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="form-group col-sm-12 text-right">
        <a type="button" class="btn btn-secondary text-white float-right ml-2" onclick="$('#devolucion-form').empty()">
            Cancelar
        </a>
        <a type="button" class="btn btn-primary text-white float-right" onclick="$('#form_dev').submit()">
            Guardar
        </a>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#fecha').datetimepicker({
            format: 'YYYY-MM-DD'
        })
        $(".selectpicker").selectpicker('refresh');
        $(":file").filestyle();
        $('#form_dev').ajaxForm({
            beforeSubmit: () => {
                $.blockUI()
            },
            success: (res) => {
                Swal.fire(
                    'Proceso exitoso',
                    res,
                    'success'
                ).then(() => {
                    $('#devolucion-form').empty()
                    cargarTabla();
                })
            },
            error: (res) => {
                if (res.status == 422)
                    mostrarErroresAjax(res)
                else
                    Swal.fire(
                        'Ocurrió un error',
                        res.responseText,
                        'error'
                    )
            },
            complete: () => {
                $.unblockUI()
            }
        })
    })

    closeModal = () => {
        $('#fotoModal').modal('hide');
    }
</script>
