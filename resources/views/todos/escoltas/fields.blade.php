@include('layouts.errors')
{!! Form::hidden('id', null, []) !!}

<div class="row">
  <div class="form-group col-sm-4">
    {!! Form::label('tipo_escolta_id', '*Tipo escolta:') !!}
    {!! Form::select('tipo_escolta_id', $tiposEscolta, null, $select) !!}
  </div>
  <div class="form-group col-sm-4">
    {!! Form::label('tipo_contrato_id', '*Tipo contrato:') !!}
    {!! Form::select('tipo_contrato_id', $tiposContrato, null, $select) !!}
  </div>
  <div class="form-group col-sm-4">
    {!! Form::label('identificacion', '*Identificación:') !!}
    {!! Form::text('identificacion', null, $input) !!}
  </div>
</div>
<div class="row">
  <div class="form-group col-sm-4">
    {!! Form::label('nombre', '*Nombre:') !!}
    {!! Form::text('nombre', null, $input) !!}
  </div>
  <div class="form-group col-sm-4">
    {!! Form::label('apellidos', '*Apellidos:') !!}
    {!! Form::text('apellidos', null, $input) !!}
  </div>
  <div class="form-group col-sm-4">
    {!! Form::label('email', '*Correo electrónico:') !!}
    {!! Form::text('email', null, $input) !!}
  </div>
</div>
<div class="row">
  <div class="form-group col-sm-4">
    {!! Form::label('ciudad_origen', '*Ciudad origen:') !!}
    {!! Form::text('ciudad_origen', null, $input) !!}
  </div>
  <div class="form-group col-sm-8">
    {!! Form::label('zonas[]', '*Zonas:') !!}
    {!! Form::select('zonas[]', $zonas, null, $selectMultiple) !!}
  </div>
</div>
<div class="row">
  <div class="form-group col-sm-4">
    {!! Form::label('celular', '*Celular:') !!}
    {!! Form::text('celular', null, $input) !!}
  </div>
  <div class="form-group col-sm-4">
    {!! Form::label('estado', '*Estado:') !!}
    {!! Form::select('estado', $estados, null, $select) !!}
  </div>
  @if (!Request::is('*edit*'))
    <div class="form-group col-sm-4">
      {!! Form::label('usuario', '*Crear usuario:') !!}
      {!! Form::select('usuario', ['0' => 'No', '1' => 'Sí'], 1, $select) !!}
    </div>
  @endif
</div>
<div class="row">
  <div class="col-sm-4">
    {!! Form::label('imagen', 'Foto:') !!} <br>
    {!! Form::file('imagen', ['onchange' => 'validarArchivo(this)', 'id' => 'imagen']) !!} <br>
    @if (Request::is('*edit*'))
      <img src="{{asset($escolta->ruta_foto)}}" class="mt-2 w-75">
    @endif
  </div>
  <div class="col-sm-8">
    <div class="row">
      <div class="col-sm-3">
        {!! Form::label('banco_id', '*Banco:') !!}
        {!! Form::select('banco_id', $bancos, null, $select) !!}
      </div>
      <div class="col-sm-3">
        {!! Form::label('tipo_cuenta_id', '*Tipo de Cuenta:') !!}
        {!! Form::select('tipo_cuenta_id', $tiposCuenta, null, $select) !!}
      </div>
      <div class="col-sm-4">
        {!! Form::label('numero_cuenta', '*Número de cuenta:') !!}
        {!! Form::text('numero_cuenta', null, $input) !!}
      </div>
      <div class="col-sm-3">
        {!! Form::label('empresa_id', '*Empresa:') !!}
        {!! Form::select('empresa_id', $empresas, null, $select) !!}
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-sm-12 text-right">
    {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
    <a href="{{route("{$perfil}.escoltas.index")}}" class="btn btn-secondary">Cancelar</a>
  </div>
</div>
<script type="text/javascript">
function validarArchivo(archivo)
{
  var extensiones_permitidas = ['.jpg', '.jpeg', '.png', '.PNG', '.JPG', '.JPEG']
  var rutayarchivo = archivo.value
  var ultimo_punto = archivo.value.lastIndexOf(".")
  var extension = rutayarchivo.slice(ultimo_punto, rutayarchivo.length)

  if(extensiones_permitidas.indexOf(extension) == -1)
  {
    Swal.fire(
      'Formato inválido',
      'El archivo debe estar en formato de imagen (jpg, jpeg, png).',
      'error'
    )
    $('#imagen').val('')
    return
  }
}
</script>
