<div class="form-group-lg">
    {{ Form::label('name', 'Ten: ', ['class' => 'label-control']) }}
    {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nhap ten vao day']) }}
</div>
<hr>

<div class="form-group-lg">
    {{ Form::label('slug', 'Slug: ', ['class' => 'label-control']) }}
    {{ Form::text('slug', null, ['class' => 'form-control', 'placeholder' => 'Nhap slug vao day']) }}
</div>
<hr>

<div class="form-group-lg">
    {{ Form::label('image', 'Hinh anh: ', ['class' => 'label-control']) }}
    {{ Form::file('image', ['class' => 'form-control']) }} 
</div>
<hr>

<div class="form-group-lg">
    {{ Form::label('description', 'Mo ta: ', ['class' => 'label-control']) }}
    {{ Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'Nhap mo ta vao day']) }}
</div>
<hr>

<div class="form-group-lg">
    {{ Form::label('publish', 'Xuat ban: ', ['class' => 'label-control']) }}
    {{ Form::checkbox('publish', '1', ['class' => 'form-control']) }}
</div>

{{ Form::submit($text_submit, ['class' => 'btn btn-primary']) }}

{{ Form::close() }}