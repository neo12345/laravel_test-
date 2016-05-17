@extends('layouts.app')

@section('content')

    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    Create posts will be queued!
    {!! Form::open([
        'route' => 'posts.store'
    ]) !!}
    @include('forms.form_posts', ['text_submit' => 'Create post'])
    
@stop