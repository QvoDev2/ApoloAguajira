@if ($editable)
    <div class='btn-group'>
        <div>
            {!! Form::button('<i class="fa fa-pencil"></i>', [
            'type' => 'submit',
            'class' => 'btn btn-secondary btn-sm',
            'data-toggle' => 'tooltip',
            'title' => 'Editar',
            'onclick' => "editar($id)"
        ]) !!}
        </div>
        {!! Form::open(['route' => ["{$perfil}.listas.destroy", $id], 'method' => 'delete']) !!}
            {!! Form::button('<i class="fa fa-trash"></i>', [
                'class' => 'btn btn-danger btn-sm eliminar',
                'data-toggle' => 'tooltip',
                'title' => 'Eliminar',
                'onclick' => "confirmar(this.form, true, () => { 
                    window.LaravelDataTables['listasTable'].draw()
                    window.LaravelDataTables['TipoListasTable'].draw()
                }); return false;"
            ]) !!}
        {!! Form::close() !!}
    </div>
@endif
