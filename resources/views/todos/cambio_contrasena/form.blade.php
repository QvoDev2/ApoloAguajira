@extends('layouts.app')

@section('title')
    Actualiza tu contraseña
@endsection

@section('content')
    <div class="alert alert-primary text-justify" role="alert">
        A continuación tienes la posibilidad de actualizar tu contraseña, para lo cual debes realizar los siguientes pasos:
        <ul>
            <li>Ingresar tu contraseña actual para verificar tu identidad.</li>
            <li>Ingresar una nueva contraseña de mínimo 8 caracteres.</li>
            <li>Confirmar tu nueva contraseña.</li>
        </ul>
        <b>Recuerda que tu contraseña es de carácter personal e intransferible. Te recomendamos actualizarla de manera periódica para mantener tu cuenta segura.</b>
    </div>

    {!! Form::open(['route' => 'actualizarContrasena', 'method' => 'PATCH']) !!}
    @include('layouts.errors')
    @include('flash::message')

    <div class="row">
        <div class="form-group col-sm-4">
            {!! Form::label('current_password', '*Contraseña actual:') !!}
            {!! Form::password('current_password', [
                'class' => 'form-control',
                'readonly',
                'onfocus' => 'quitarAutocomplete(this)'
                ]) !!}
        </div>

        <div class="form-group col-sm-4">
            {!! Form::label('password', '*Contraseña nueva:') !!}
            {!! Form::password('password', [
                'class' => 'form-control',
                'readonly',
                'onfocus' => 'quitarAutocomplete(this)'
                ]) !!}
        </div>

        <div class="form-group col-sm-4">
            {!! Form::label('password_confirmation', '*Repetir contraseña nueva:') !!}
            {!! Form::password('password_confirmation', [
                'class' => 'form-control',
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
        <div class="form-group col-sm-12">
            {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
        </div>
    </div>

    {!! Form::close() !!}
@endsection

