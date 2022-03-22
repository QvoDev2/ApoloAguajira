<div class="card">
    <div class="card-body">
        {!! Form::open(['route' => ['admin.pagos.store', $comision->id], 'id' => 'form']) !!}
        @include('todos.pagos.fields')
        {!! Form::close() !!}
    </div>
</div>
