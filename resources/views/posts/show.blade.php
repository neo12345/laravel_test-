@extends('layouts.app')

@section('content')
        <h3>{{ $post->title }}</h3>
        <p>{{ $post->description }}</p>
        <p>          
            {{ Form::open([
                'method' => 'DELETE',
                'route' => ['posts.destroy', $post->id]
            ])}}
                <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-primary">Edit</a>
                {{ Form::submit('Delete', ['class' => 'btn btn-danger'])}}
            {{ Form::close()}}
        </p>
        <p><a href="{{ route('posts.index')}}"><h4>Back to Posts List</h4></a></p>
@stop

