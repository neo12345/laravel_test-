@extends('layouts.master')

@section('content')
    <h1>News list</h1>
    
    @foreach($news as $line)
        <h3>{{ $line->title }}</h3>
        <p>{{ $line->description }}</p>
        <p>
            <a href="{{ route('news.show', $line->id) }}" class="btn btn-info">Read more</a>
        </p>
    @endforeach
    <hr>
    <a href="{{ route('news.create') }}"/><h4>Create a news</h4></a>
@endsection