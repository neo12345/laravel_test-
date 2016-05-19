@extends('layouts.app')

@section('content')
<div class="container">
<h3>Tao category moi</h3>
<hr>

@if($errors->any())
<div class="alert alert-danger">
    @foreach($errors->all() as $error)
    <p>{{ $error }}</p>
    @endforeach
</div>
@endif

{{ Form::open([
    'method' => 'POST',
    'route' => 'categories.store',
]) }}

@include('categories._form', ['submit_text' => 'Tao moi'])
</div>
@endsection