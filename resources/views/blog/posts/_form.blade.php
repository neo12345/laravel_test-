<div class="form-inline">
    {{ Form::label('title', 'Title: ', ['class' => 'label-control']) }}
    {{ Form::text('title', null, ['class' => 'form-control']) }}
</div>

<div class="form-inline">
    {{ Form::label('subtitle', 'Subtitle: ', ['class' => 'label-control']) }}
    {{ Form::text('subtitle', null, ['class' => 'form-control']) }}
</div>

<div class="form-inline">
    {{ Form::label('description', 'Description: ', ['class' => 'label-control']) }}
    {{ Form::text('description', null, ['class' => 'form-control']) }}
</div>

<div class="form-inline">
    {{ Form::label('content', 'Content: ', ['class' => 'label-control']) }}
    {{ Form::textarea('content', null, ['class' => 'form-control']) }}
</div>

<div class="form-inline">
    {{ Form::label('feature_image', 'Feature image: ', ['class' => 'label-control']) }}
    {{ Form::file('feature_image', ['class' => 'form-control']) }}
</div>

<div class="form-inline">
    {{ Form::checkbox('is_draft', 1, ['class' => 'form-control']) }} Draft
</div>
{{ Form::submit( $submit_text , ['class' => 'form-control']) }}


{{ Form::close() }}