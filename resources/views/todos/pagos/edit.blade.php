<div class="card">
    <div class="card-body">
        {!! Form::model($pago, ['route' => ['admin.pagos.update', $pago->id], 'id' => 'form', 'method' => 'patch']) !!}
        {!! Form::hidden('id', null, []) !!}
        @include('todos.pagos.fields')
        {!! Form::close() !!}
    </div>
</div>
