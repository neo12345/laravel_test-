@extends('layouts.app')

@section('content')
<div class="container">
    <a href="{{ route('comics.show', $comic->slug) }}" class="btn btn-info">Tro lai</a>
    <hr>
    
    @if(Gate::forUser($user)->allows('store', $auth))
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
    
    <div class="form-group">
        <a href="{{ route('comics.chapters.pages.create', [$comic->slug, $chapter->name]) }}" class="btn btn-primary">Them trang</a>
    </div>       
    @endif
    
    @foreach($chapter->pages as $page)
    <img class="img-responsive" src="{{ url('../storage/app/public').'/'.$page->link }}"/>
    @endforeach
    
    <div id="navigation" style="align-content: center">
        @if($prev)
        <a href="{{ route('comics.chapters.show', [$comic->slug, $prev->name]) }}" class="btn btn-lg btn-primary">Prev</a>
        @endif
        @if($next)
        <a href="{{ route('comics.chapters.show', [$comic->slug, $next->name]) }}" class="btn btn-lg btn-primary">Next</a>
        @endif
    </div>
</div>    
@endsection