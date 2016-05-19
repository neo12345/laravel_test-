@extends('layouts.app')

@section('content')
<h3>Tao truyen moi</h3>

@if($errors->any())
<div class="alert alert-danger">
    @foreach($errors->all() as $error)
    <p>{{ $error }}</p>
    @endforeach
</div>
@endif

{{ Form::open([
    'route' => 'comics.store',
    'method' => 'POST',
    'files' => 'true',
]) }}

@include('comics._form', ['text_submit' => 'Tao moi'])
@endsection