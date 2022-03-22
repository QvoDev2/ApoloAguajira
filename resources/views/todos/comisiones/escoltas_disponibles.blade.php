@forelse ($escoltasActivos as $escolta)
    <li data-id="{{$escolta->id}}">
        <div class="form-row">
            <div class="col-sm-2">
                <img src="{{asset($escolta->ruta_foto)}}" class="w-100 rounded-circle">
            </div>
            <div class="col-sm-10 info">
                {{ $escolta->nombre_completo }} <br>
                <small>CC: {{ $escolta->identificacion }}</small>
            </div>
        </div>
        <div id="e{{$escolta->id}}" style="display: none" class="mt-1">
            {!! Form::number(null, null, $input + ['placeholder' => 'Código autorización']) !!}
        </div>
    </li>
@empty
@endforelse

@forelse ($esoltasDisponibles as $escolta)
    <li data-id="{{$escolta->id}}" class="disponible oculto">
        <div class="form-row">
            <div class="col-sm-2">
                <img src="{{asset($escolta->ruta_foto)}}" class="w-100 rounded-circle">
            </div>
            <div class="col-sm-10 info">
                {{ $escolta->nombre_completo }} <br>
                <small>{{ $escolta->identificacion }}</small>
            </div>
        </div>
        <div id="e{{$escolta->id}}" style="display: none" class="mt-1">
            {!! Form::number(null, null, $input + ['placeholder' => 'Código autorización']) !!}
        </div>
    </li>
@empty
@endforelse