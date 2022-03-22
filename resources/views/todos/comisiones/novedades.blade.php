<form action="{{ route("{$perfil}.comisiones.procesar", $comision->id) }}" id="form-comision" method="post">
    @csrf
    <div class="row">
        <div class="col-sm-12 form-group">
            Ingrese una observación
            {!! Form::text('observaciones', null, $input + ['id' => 'observaciones']) !!}
        </div>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Usuario</th>
                <th>Observación</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($comision->novedades as $novedad)
                <tr>
                    <td>{{ $novedad->created_at->format('d/m/Y g:i A') }}</td>
                    <td>{{ $novedad->usuario->nombre_completo }}</td>
                    <td>{{ $novedad->observaciones }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <input type="hidden" name="estado" value="{{ $comision::ESTADO_NOVEDAD }}">
</form>