@extends('layouts.app')

@section('content')
<p>
    <a href="{{ route('comics.show', $comic->slug) }}" class="btn-lg btn-info">Quay lai</a>
</p>
<h3>Tao chuong moi</h3>
<hr>
@if($errors->any())
<div class="alert alert-danger">
    @foreach($errors->all() as $error)
    <p>{{ $error }}</p>
    @endforeach
</div>
@endif
<div class="container">
{{ Form::open([
    'method' => 'POST',
    'route' => ['comics.chapters.store', $comic->slug],
]) }}
@include('chapters._form', ['submit_text' => 'Tao moi'])
</div>
@endsection
