<div class="form-group">
    {{ Form::label('name', 'Ten: ', ['class' => 'label-control']) }}
    {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Dien ten vao day']) }}
</div>

<div class="form-group">
    {{ Form::label('slug', 'Slug: ', ['class' => 'label-control']) }}
    {{ Form::text('slug', null, ['class' => 'form-control', 'placeholder' => 'Dien slug vao day']) }}
</div>

<div class="form-group">
    {{ Form::label('description', 'Mo ta: ', ['class' => 'label-control']) }}
    {{ Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'Dien mo ta vao day']) }}
</div>

{{ Form::submit($submit_text, ['class' => 'btn btn-primary']) }}

{{ Form::close() }}