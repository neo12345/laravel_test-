<div class="form-group">
    {{ Form::label('name', 'Ten: ', ['class' => 'label-control']) }}
    {{ Form::text('name', null, ['class' => 'form-control']) }}
</div>
<hr>

<div class="form-inline">
    {{ Form::label('publish', 'Xuat ban: ', ['class' => 'label-control']) }}
    {{ Form::checkbox('publish', '1', true, ['class' => 'form-control']) }}
</div>
<hr>

{{ Form::submit($submit_text, ['class' => 'btn btn-primary']) }}

{{ Form::close() }}