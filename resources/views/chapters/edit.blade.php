@extends('layouts.app')

@section('content')
<div class="container">
<h3>{{ $chapter->name }}</h3>
<hr>

@if($errors->any())
<div class="alert alert-danger">
    @foreach($errors->all() as $error)
    <p>{{ $error }}</p>
    @endforeach
</div>
@endif


{{ Form::model($chapter, [
    'method' => 'PATCH',
    'route' => ['comics.chapters.update', $comic->slug, $chapter->name],
]) }}
@include('chapters._form', ['submit_text' => 'Chinh sua'])
</div>
@endsection
