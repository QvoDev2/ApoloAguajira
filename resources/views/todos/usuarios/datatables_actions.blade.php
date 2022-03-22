{!! Form::open(['route' => ["{$perfil}.usuarios.destroy", $id], 'method' => 'delete']) !!}
    <div class='btn-group'>
        @if (Auth::user()->id != $id)
            @if ($estado)
                <a class="btn btn-danger btn-sm text-white" title="Inhabilitar" onclick="cambiarEstado({{$id}})" data-toggle="tooltip"><i class="fa fa-times"></i></a>
            @else
                <a class="btn btn-success btn-sm text-white" title="Habilitar" onclick="cambiarEstado({{$id}})" data-toggle="tooltip"><i class="fa fa-check"></i></a>
            @endif
        @endif
        <a onclick="confirmarRestablecerContrasena({{ $id }})" class="btn btn-primary btn-sm text-white" title="Restablecer contraseña">
            <i class="fa fa-lock"></i>
        </a>
        <a href="{{route("{$perfil}.usuarios.edit", $id)}}" class="btn btn-secondary btn-sm" title="Editar">
            <i class="fa fa-pencil"></i>
        </a>
        @if (Auth::user()->id != $id)
            {!! Form::button('<i class="fa fa-trash"></i>', [
                'class' => 'btn btn-danger btn-sm eliminar',
                'data-toggle' => 'tooltip',
                'title' => 'Eliminar',
                'onclick' => "confirmar(this.form, true, () => { window.LaravelDataTables['UsuariosTable'].draw()}); return false;"
            ]) !!}
        @endif
    </div>
{!! Form::close() !!}
