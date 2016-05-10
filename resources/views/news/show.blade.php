@extends('layouts.app')

@section('content')
    <h3>{{ $news->title }}</h3>
    <b>{{ $news->description }}</b>
    <p>{{ $news->content }}</p>
    
    <p>           
        {{ Form::open([
            'method' => 'DELETE',
            'route' => ['news.destroy', $news->id]      
        ]) }}
        
            <a href="{{ route('news.edit', $news->id) }}" class="btn btn-info">Edit</a>
            {{ Form::submit('Delete', ['class' => 'btn btn-danger']) }}
        
        {{ Form::close() }}
    </p>
    <p><a href="{{ route('news.index') }}">Back to News list</a></p>
@endsection