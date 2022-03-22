{!! Form::hidden('tipo_lista_id', $id ?? null, []) !!}

<div class="row">
    <div class="form-group col-sm-12">
        {!! Form::label('codigo', ($id ?? $lista->tipo_lista_id) == 7 ? 'Valor por día:' : 'Código:') !!}
        {!! Form::text('codigo', null, $input + ['maxlength' => '50']) !!}
    </div>
</div>

<div class="row">
    <div class="form-group col-sm-12">
        {!! Form::label('nombre', '*Nombre:') !!}
        {!! Form::text('nombre', null, $input + ['maxlength' => '50']) !!}
    </div>
</div>

<div class="row">
    <div class="form-group col-sm-12">
        {!! Form::label('descripcion', 'Descripción:') !!}
        {!! Form::textarea('descripcion', null, $textarea + ['maxlength' => '500']) !!}
    </div>
</div>

<div class="row">
    <div class="form-group col-sm-12">
        {!! Form::label('lista_id', 'Pertenece a:') !!}
        {!! Form::select('lista_id', $listas, null, $select + ['data-container' => 'body'])!!}
    </div>
</div>

<div class="row">
    <div class="form-group col-sm-12 text-right">
        {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
        <a onclick="verListas({{$id ?? $lista->tipo_lista_id}})" class="btn btn-secondary text-white">Cancelar</a>
    </div>
</div>

<script type="text/javascript">
    $('.selectpicker').selectpicker()
    $('#lista-form').ajaxForm({
        beforeSubmit: function () {
            $.blockUI()
        }, success: function (res) {
            $.unblockUI()
            Swal.fire(
                'Proceso exitoso',
                res,
                'success'
            ).then(() => {
                verListas({{$id ?? $lista->tipo_lista_id}})
                window.LaravelDataTables['TipoListasTable'].draw()
            })
        }, error: function (res) {
            $.unblockUI()
            if(res.status == 422)
                mostrarErroresAjax(res)
            else
                Swal.fire(
                    'Ocurrió un error',
                    res.responseText,
                    'error'
                )
        }
    })
</script>
