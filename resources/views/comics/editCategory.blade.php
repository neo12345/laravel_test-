@extends('layouts.app')

@section('content')
<div class="container">
    <h3>{{ $comic->name }}</h3>
    <hr>
    
    {{ Form::model($comic, [
    'method' => 'PUT',
    'route' => ['comics.updateCategory', $comic->slug],
]) }}
    <div class="row">
    @foreach($categories as $category)
    
    <div class="col-md-2">
        <div class="form-inline">
            {{ Form::label($category->slug, $category->name . ': ', ['class' => 'label-control']) }}
            {{ Form::checkbox($category->slug, 1, ['class' => 'form-control']) }}
        </div>
    </div>
    @endforeach
    </div>
    <hr>
    {{ Form::submit('Luu lai', ['class' => 'btn btn-primary']) }}
    
    {{ Form::close() }}
</div>  
@endsection