{!! Form::open(['route' => ["{$perfil}.ciudades.destroy", $id], 'method' => 'delete']) !!}
    <div class='btn-group'>
        <a href="{{route("{$perfil}.ciudades.edit", $id)}}" class="btn btn-secondary btn-sm" data-toggle="tooltip" title="Editar"><i class="fa fa-pencil"></i></a>
        {!! Form::button('<i class="fa fa-trash"></i>', [
            'class' => 'btn btn-danger btn-sm eliminar',
            'data-toggle' => 'tooltip',
            'title' => 'Eliminar',
            'onclick' => "confirmar(this.form, true, () => { window.LaravelDataTables['CiudadesTable'].draw() }); return false;"
        ]) !!}
    </div>
{!! Form::close() !!}
