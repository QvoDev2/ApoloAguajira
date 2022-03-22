@if ($comision->paso_creacion)
    {!! Form::open(['route' => ["{$perfil}.comisiones.destroy", $comision->id], 'method' => 'delete']) !!}
    <div class='btn-group'>
        <a href="{{ route("{$perfil}.comisiones.continuar", $comision->id) }}" class="btn btn-secondary btn-sm"
            data-toggle="tooltip" title="Continuar">
            <i class="fas fa-forward"></i>
        </a>
        {!! Form::button('<i class="fa fa-trash"></i>', [
    'class' => 'btn btn-danger btn-sm eliminar',
    'data-toggle' => 'tooltip',
    'title' => 'Eliminar',
    'onclick' => "confirmar(this.form, true, () => { window.LaravelDataTables['ComisionesTable'].draw() }); return false;",
]) !!}
    </div>
    {!! Form::close() !!}
@else
    <div class="btn-group">
        <a onclick="verComision({{ $comision->id }})" class="btn btn-primary btn-sm text-white" data-toggle="tooltip"
            title="Ver detalles">
            <i class="far fa-eye"></i>
        </a>
        @if (in_array($comision->estado, [App\Models\Comision::ESTADO_ASIGNADO, App\Models\Comision::ESTADO_EN_CURSO, App\Models\Comision::ESTADO_FINALIZADO]))
            <a href="{{ route("{$perfil}.comisiones.edit", $comision->id) }}" class="btn btn-secondary btn-sm"
                data-toggle="tooltip" title="Editar">
                <i class="fa fa-pencil"></i>
            </a>
        @endif
        @if (Auth::user()->id == 3 || Auth::user()->id == 70)
            <a onclick="verPagos({{ $comision->id }})" class="btn btn-primary btn-sm text-white" data-toggle="tooltip"
                title="Pagos">
                <i class="fas fa-dollar-sign" aria-hidden="true"></i>
            </a>
        @endif
        @foreach ($comision->acciones as $accion)
            @if (!isset($accion['perfiles']) || (isset($accion['perfiles']) && in_array($sesion->perfil_id, $accion['perfiles'])))
                <a class="btn btn-{{ $accion['color'] }} text-white btn-sm"
                    onclick="procesarComision({{ $comision->id }}, {{ $accion['estado'] }}, '{{ $accion['accion'] }}', '{{ isset($accion['funcion']) ? $accion['funcion'] : '' }}')"
                    title="{{ $accion['accion'] }}">
                    <i class="{{ $accion['icono'] }}"></i>
                </a>
            @endif
        @endforeach
    </div>
@endif
