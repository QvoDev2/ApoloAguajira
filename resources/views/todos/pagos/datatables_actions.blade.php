{!! Form::open(['route' => ['admin.pagos.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    <a onclick="editarPago({{ $id }})" class="btn btn-primary btn-sm text-white" data-toggle="tooltip"
        title="Editar">
        <i class="fa fa-edit"></i>
    </a>
    {!! Form::button('<i class="fa fa-trash"></i>', [
    'class' => 'btn btn-danger btn-sm eliminar',
    'data-toggle' => 'tooltip',
    'title' => 'Eliminar',
    'onclick' => "confirmar(this.form, true, () => { 
                window.LaravelDataTables['PagoTable'].draw()
            }); return false;",
]) !!}
</div>
{!! Form::close() !!}
