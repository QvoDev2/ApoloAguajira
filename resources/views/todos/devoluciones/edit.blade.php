<div class="card">
    <div class="card-body">
        {!! Form::model($devolucion, ['route' => ['admin.devoluciones.update', $devolucion->id], 'id' => 'form_dev', 'method' => 'patch', 'enctype' => 'multipart/form-data']) !!}
        {!! Form::hidden('id', null, []) !!}
        @include('todos.devoluciones.fields')
        {!! Form::close() !!}
    </div>
</div>
