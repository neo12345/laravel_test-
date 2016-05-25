@extends('layouts.app')

@section('content')
<h3>Danh sach</h3>
<hr/>
<div class="container">
    @if(Gate::forUser($user)->allows('store', $auth))
    <p>
        <a href="{{ route('comics.create') }}" class="btn-lg btn-primary">Tao moi</a>
    </p>
    <hr>
    @endif
    
    @foreach($comics as $comic)
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
    {{ $comics->render() }}
</div>
@endsection