@include('layouts.errors')

{!! Form::hidden('id', null, []) !!}
<div class="row">
    <div class="form-group col-sm-4">
        {!! Form::label('nombres', '*Nombres:') !!}
        {!! Form::text('nombres', null, $input) !!}
    </div>

    <div class="form-group col-sm-4">
        {!! Form::label('apellidos', '*Apellidos:') !!}
        {!! Form::text('apellidos', null, $input) !!}
    </div>

    <div class="form-group col-sm-4">
        {!! Form::label('documento', '*Documento:') !!}
        {!! Form::text('documento', null, $input) !!}
    </div>
</div>

<div class="row">
    <div class="form-group col-sm-4">
        {!! Form::label('email', '*Correo electrónico:') !!}
        {!! Form::text('email', null, $input) !!}
    </div>

    <div class="form-group col-sm-4">
        {!! Form::label('celular', '*Celular:') !!}
        {!! Form::text('celular', null, $input) !!}
    </div>

    <div class="form-group col-sm-4">
        {!! Form::label('perfil_id', '*Perfil:') !!}
        {!! Form::select('perfil_id', $perfiles, null, $select) !!}
    </div>
</div>

<div class="row">
    <div class="form-group col-sm-4">
        {!! Form::label('zonas[]', '*Zonas:') !!}
        {!! Form::select('zonas[]', $zonas, null, $selectMultiple) !!}
    </div>

    <div class="form-group col-sm-4">
        {!! Form::label('escolta_id', 'Escolta:') !!}
        {!! Form::select('escolta_id', $escoltas, null, $select) !!}
    </div>
</div>

<div class="row">
    <hr class="col-sm-12" size="1">
</div>

<div class="row">
    <div class="form-group col-sm-4">
        {!! Form::label('password', '*Contraseña:') !!}
        {!! Form::password('password', $input + [
            'readonly',
            'onfocus' => 'quitarAutocomplete(this)'
            ]) !!}
    </div>

    <div class="form-group col-sm-4">
        {!! Form::label('password_confirmation', '*Repetir contraseña:') !!}
        {!! Form::password('password_confirmation', $input + [
            'readonly',
            'onfocus' => 'quitarAutocomplete(this)'
        ]) !!}
    </div>
</div>

@push('scripts')
<script type="text/javascript">
    function quitarAutocomplete(campo) {
        if (campo.hasAttribute("readonly")) {
            campo.removeAttribute("readonly");
            campo.blur();
            campo.focus();
        }
    }
    </script>
@endpush

<div class="row">
    <div class="form-group col-sm-12 text-right">
        {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
        <a href="{{route("{$perfil}.usuarios.index")}}" class="btn btn-secondary">Cancelar</a>
    </div>
</div>
