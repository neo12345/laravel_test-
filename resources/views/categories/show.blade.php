@extends('layouts.app')

@section('content')
<div class="container">
    <h3>{{ $category->name }}</h3>
    <hr>
    {{ $category->description }}
    <hr>
    
    @if(Gate::forUser($user)->allows('store', $auth))
    {{ Form::open([
        'method' => 'DELETE',
        'route' => ['categories.destroy', $category->slug],
    ]) }}
        <a href="{{ route('categories.edit', $category->slug) }}" class="btn btn-warning">Sua doi</a>
        {{ Form::submit('Xoa', ['class' => 'btn btn-danger']) }}
    {{ Form::close() }}
    @endif
    <hr>
    <div class="panel panel-default">
        <div class="panel-heading">
            <b>Danh sach</b>
        </div>
        <div class="panel-body">
            @foreach($category->comics as $comic)
            <div class="col-md-2">
                <div class="thumbnail">
                    <a href="{{ route('comics.show', $comic->slug) }}">
                        <img src="{{ $comic->image }}" />
                    </a>
                </div>
                <hr>
                <div class="text-center">
                    <h4>{{ $comic->name }}</h4>
                    <a href="{{ route('comics.show', $comic->slug) }}" class="btn-lg btn-info">Doc tiep</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection