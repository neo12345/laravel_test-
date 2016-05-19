@extends('layouts.app')

@section('content')
<div class="container">
    <a href="{{ route('comics.show', $comic->slug) }}" class="btn btn-info">Tro lai</a>
    <hr>
    <div class="form-group">
        {{ Form::open([
            'method' => 'DELETE',
            'route' => ['comics.chapters.destroy', $comic->slug, $chapter->name],
        ]) }}
            <a href="{{ route('comics.chapters.edit', [$comic->slug, $chapter->name])}}" class="btn btn-warning">Chinh sua</a>
            {{ Form::submit('Xoa', ['class' => 'btn btn-danger']) }}
        {{ Form::close() }}
    </div>
    <hr>
    @foreach($chapter->pages as $page)
    <img src="{{ $page->link }}"/>
    @endforeach
</div>    
@endsection