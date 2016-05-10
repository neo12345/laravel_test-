@extends('layouts.app')

@section('content')
    <h3>Edit post</h3>

    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>    
    @endif

    {{ Form::model($post,[
        'method' => 'PATCH',
        'route' => ['posts.update', $post->id]
    ]) }}

    @include('forms.form_posts', ['text_submit' => 'Update'])
@stop

