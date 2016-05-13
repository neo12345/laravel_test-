@extends('layouts.master')

@section('content')
    @if($errors->any())
    <div class="danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    
    <h3>Create new post</h3>
    <hr/>
    {{ Form::open([
        'method' => 'POST',
        'route' => 'blog.posts.store',
        'files' => true,
        'class' => 'form-group'
    ]) }}
    
    @include('blog.posts._form', ['submit_text' => 'Create'])
        
@endsection