@extends('layouts.app')

@section('content')
    <h3>Posts List</h3>
    <a href="{{ route('posts.create') }}"><h4>Create a post</h4></a>
    <table class="table-hover">
        <thead>
            <th width='200px'>Title</th>
            <th width='300px'>Description</th>
            <th width='200px'>Last Update</th>
            <th width='200px'>Details</th>
        </thead>
        <tbody>
                @foreach ($posts as $post)
                    <tr>
                        <td><h5>{{ $post->title }}</h5></td>
                        <td><p>{{ $post->description }}</p></td>
                        <td><p>{{ $post->updated_at }}</p></td>
                        <td><p><a href="{{ route('posts.show', $post->id) }}" class="btn btn-primary">Read more</a></p></td>
                    </tr>
                @endforeach            
        </tbody>
    </table>    
    {!! $posts->render() !!}
@stop