@include('layouts.errors')
{!! Form::hidden('id', null, []) !!}
<div class="row form-group">
    <div class="col-sm-6">
        {!! Form::label('nombre', '*Nombre:') !!}
        {!! Form::text('nombre', null, $input) !!}
    </div>
    <div class="col-sm-6">
        {!! Form::label('zona_id', '*Zona:') !!}
        {!! Form::select('zona_id', $zonas, null, $select) !!}
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        {!! Form::label('ciudad_id', '*Origen:') !!}
        {!! Form::select('ciudad_id', $ciudades, null, $select) !!}
    </div>
</div>
<div class="row">
    <div class="col-sm-12 text-right">
        {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
        <a href="{{route("{$perfil}.clientes.index")}}" class="btn btn-secondary">Cancelar</a>
    </div>
</div>
