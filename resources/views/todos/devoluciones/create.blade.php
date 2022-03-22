<div class="card">
    <div class="card-body">
        {!! Form::open(['route' => ['admin.devoluciones.store', $comision->id], 'id' => 'form_dev', 'enctype' => 'multipart/form-data']) !!}
        @include('todos.devoluciones.fields')
        {!! Form::close() !!}
    </div>
</div>
