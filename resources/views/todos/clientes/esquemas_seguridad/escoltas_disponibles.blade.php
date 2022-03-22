@forelse ($esoltasDisponibles as $escolta)
    <li data-id="{{ $escolta->id }}">
        <div class="form-row">
            <div class="col-sm-3">
                <img src="{{ asset($escolta->ruta_foto) }}" class="w-100 rounded-circle">
            </div>
            <div class="col-sm-9">
                {{ $escolta->nombre_completo }} <br>
                <small>{{ $escolta->identificacion }}</small>
            </div>
        </div>
        <div id="e{{ $escolta->id }}" style="display: none" class="mt-1">
            {!! Form::text(null, date('Y-m-d'), ['placeholder' => 'Fecha vinculación', 'class' => 'form-control datetimepicker vinculacion']) !!}
            {!! Form::text(null, null, ['placeholder' => 'Fecha retiro', 'class' => 'form-control datetimepicker retiro']) !!}
        </div>
    </li>
@empty
@endforelse

<script type="text/javascript">
    $(function() {
        $('i').css('cursor', 'pointer')
    })
</script>
