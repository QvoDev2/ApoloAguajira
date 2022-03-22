{!! Form::open(['route' => ["{$perfil}.clientes.destroy", $id], 'method' => 'delete']) !!}
    <div class='btn-group'>
        <a href="{{route("{$perfil}.clientes.edit", $id)}}" class="btn btn-secondary btn-sm" data-toggle="tooltip" title="Editar"><i class="fa fa-pencil"></i></a>
        <a onclick='gestionarEsquema({{$id}})' class="btn btn-primary btn-sm text-white" data-toggle="tooltip" title="Personal asignado"><i class="fas fa-user-shield"></i></a>
        {!! Form::button('<i class="fa fa-trash"></i>', [
            'class' => 'btn btn-danger btn-sm eliminar',
            'data-toggle' => 'tooltip',
            'title' => 'Eliminar',
            'onclick' => "confirmar(this.form, true, () => { window.LaravelDataTables['ClientesTable'].draw() }); return false;"
        ]) !!}
    </div>
{!! Form::close() !!}
