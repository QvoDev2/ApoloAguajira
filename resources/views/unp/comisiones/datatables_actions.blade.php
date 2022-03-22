@if($comision->paso_creacion)
    <a href="{{route("{$perfil}.comisiones.continuar", $comision->id)}}" class="btn btn-secondary btn-sm" data-toggle="tooltip" title="Continuar">
        <i class="fas fa-forward"></i>
    </a>
@else
    <div class="btn-group">
        <a onclick="verComision({{$comision->id}})" class="btn btn-primary btn-sm text-white" data-toggle="tooltip" title="Ver detalles">
            <i class="far fa-eye"></i>
        </a>
        @foreach ($comision->acciones as $accion)
            @if (!isset($accion['perfiles']) || (isset($accion['perfiles']) && in_array($sesion->perfil_id, $accion['perfiles'])))
                <a class="btn btn-{{ $accion['color'] }} text-white btn-sm" 
                    onclick="procesarComision({{$comision->id}}, {{ $accion['estado'] }}, '{{ $accion['accion'] }}', '{{ isset($accion['funcion']) ? $accion['funcion'] : '' }}')" title="{{ $accion['accion'] }}">
                    <i class="{{ $accion['icono'] }}"></i>
                </a>
            @endif
        @endforeach
    </div>
@endif