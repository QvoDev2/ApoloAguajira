@extends('layouts.app')

@section('title')
    Editando comisión
@endsection

@section('content')
    {!! Form::model($comisione, ['route' => ["{$perfil}.comisiones.update", $comisione->id], 'method' => 'patch']) !!}
        @include('todos.comisiones.steps_edit', ['step' => 1, 'id' => $comisione->id])
        @include('layouts.errors')
        {!! Form::hidden('id', null, []) !!}
        <div class="row form-group">
            <div class="col-sm-3">
                {!! Form::label('fecha_aprobacion_correo', '*Fecha aprobación correo:') !!}
                {!! Form::text('fecha_aprobacion_correo', null, $datetimepicker) !!}
            </div>
            <div class="col-sm-3">
                {!! Form::label('fecha_inicio', '*Fecha inicio:') !!}
                {!! Form::text('fecha_inicio', null, $datetimepicker) !!}
            </div>
            <div class="col-sm-3">
                {!! Form::label('fecha_fin', '*Fecha fin:') !!}
                {!! Form::text('fecha_fin', null, $datetimepicker) !!}
            </div>
            <div class="col-sm-3">
                {!! Form::label('tipo', '*Tipo:') !!}
                {!! Form::select('tipo', ['Normal', 'Sólo desplazamiento'], null, $select) !!}
            </div>
        </div>
        <div class="row form-group">
            <div class="col-sm-6">
                {!! Form::label('cliente_id', '*Esquema:') !!}
                <select name="cliente_id" onchange="$('#valor_x_dia').val($(this).find('option:selected').data('valor')); $('#departamento_id').selectpicker('val', $(this).find('option:selected').data('departamento_id')); $('#origen').val($(this).find('option:selected').data('origen'))" class='form-control selectpicker bordered'  data-style='form-control' data-live-search='true' title='Seleccione'>
                    @foreach ($clientes as $cliente)
                        @php
                            $ciudad = $cliente->ciudad;
                            $zona = $cliente->zona;
                        @endphp
                        <option data-subtext="{{$zona->nombre}}" @if ($cliente->id == $comisione->cliente_id) selected @endif value="{{$cliente->id}}" data-valor="{{$zona->codigo}}" data-departamento_id="{{$ciudad->lista_id ?? ''}}" data-origen="{{$ciudad->nombre ?? ''}}">{{$cliente->nombre}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-3">
                {!! Form::label('valor_x_dia', '*Valor por día:') !!}
                {!! Form::text('valor_x_dia', null, $input + ['readonly']) !!}
            </div>
            <div class="col-sm-3">
                {!! Form::label('dias_aprobados', '*Días aprobados:') !!}
                {!! Form::text('dias_aprobados', null, $input + ['onkeyup' => 'this.value=soloNumeros(this.value,true)']) !!}
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="row form-group">
                    <div class="col-sm-6">
                        {!! Form::label('departamento_id', '*Departamento:') !!}
                        {!! Form::select('departamento_id', $departamentos, null, $select) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::label('origen', '*Origen:') !!}
                        {!! Form::text('origen', null, $input + ['id' => 'origen']) !!}
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-sm-6">
                        {!! Form::label('tipo_desplazamiento_id', '*Medio desplazamiento:') !!}
                        {!! Form::select('tipo_desplazamiento_id', $tiposDesplazamiento, null, $select) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::label('viajero', 'Viajero:') !!}
                        {!! Form::text('viajero', null, $input) !!}
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                {!! Form::label('observaciones', 'Observaciones:') !!}
                {!! Form::textarea('observaciones', null, $textarea) !!}
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-12 text-right">
                {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
                <a href="{{route("{$perfil}.comisiones.index")}}" class="btn btn-secondary">Cancelar</a>
            </div>
        </div>
    {!! Form::close() !!}
@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.datetimepicker').datetimepicker({
                format: 'YYYY-MM-DD'
            })
        })
    </script>
@endpush