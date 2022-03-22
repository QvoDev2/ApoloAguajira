@include('layouts.errors')
{!! Form::hidden('id', null, []) !!}
<div class="row">
    <div class="form-group col-sm-4">
        {!! Form::label('nombre', '*Nombre:') !!}
        {!! Form::text('nombre', null, $input) !!}
    </div>
    <div class="form-group col-sm-4">
        {!! Form::label('tipo_vehiculo_id', '*Tipo:') !!}
        {!! Form::select('tipo_vehiculo_id', $tipos, null, $select) !!}
    </div>
    <div class="form-group col-sm-4">
        {!! Form::label('placa', '*Placa:') !!}
        {!! Form::text('placa', null, $input) !!}
    </div>
</div>
<div class="row">
    <div class="form-group col-sm-4">
        {!! Form::label('modelo', '*Modelo:') !!}
        {!! Form::text('modelo', null, $input) !!}
    </div>
    <div class="form-group col-sm-4">
        {!! Form::label('marca', '*Marca:') !!}
        {!! Form::text('marca', null, $input) !!}
    </div>    
</div>
<div class="row">
    <div class="form-group col-sm-12 text-right">
        {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
        <a href="{{route("{$perfil}.vehiculos.index")}}" class="btn btn-secondary">Cancelar</a>
    </div>
</div>
