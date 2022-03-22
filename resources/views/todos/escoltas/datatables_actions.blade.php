{!! Form::open(['route' => ["{$perfil}.escoltas.destroy", $escolta->id], 'method' => 'delete']) !!}
    <div class='btn-group'>
        <a href="{{route("{$perfil}.escoltas.edit", $escolta->id)}}" class="btn btn-secondary btn-sm" data-toggle="tooltip" title="Editar">
            <i class="fa fa-pencil"></i>
        </a>
        @if ($usuario = $escolta->usuario)
            <a onclick="confirmarRestablecerContrasena({{ $usuario->id }})" class="btn btn-primary btn-sm text-white" title="Restablecer contraseña">
                <i class="fa fa-lock"></i>
            </a>
        @endif
        {!! Form::button('<i class="fa fa-trash"></i>', [
            'class' => 'btn btn-danger btn-sm eliminar',
            'data-toggle' => 'tooltip',
            'title' => 'Eliminar',
            'onclick' => "confirmar(this.form, true, () => { window.LaravelDataTables['EscoltasTable'].draw() }); return false;"
        ]) !!}
    </div>
{!! Form::close() !!}
