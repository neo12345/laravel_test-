@extends('layouts.app')

@section('content')
<p>
    <a href="{{ route('comics.show', $comic->id) }}" class="btn-lg btn-info">Quay lai</a>
</p>

<h3>{{ $comic->name }}</h3>

@if($errors->any())
<div class="alert alert-danger">
    @foreach($errors->all() as $error)
    <p>{{ $error }}</p>
    @endforeach
</div>
@endif

{{ Form::model($comic, [
    'route' => ['comics.update', $comic->slug],
    'method' => 'PUT',
    'files' => 'true',
]) }}

@include('comics._form', ['text_submit' => 'Luu lai'])
@endsection