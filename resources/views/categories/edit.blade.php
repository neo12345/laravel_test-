@extends('layouts.app')

@section('content')
<div class="container">
<h3>Sua category</h3>
<hr>

@if($errors->any())
<div class="alert alert-danger">
    @foreach($errors->all() as $error)
    <p>{{ $error }}</p>
    @endforeach
</div>
@endif

{{ Form::model($category, [
    'method' => 'PATCH',
    'route' => ['categories.update', $category->slug],
]) }}

@include('categories._form', ['submit_text' => 'Sua doi'])
</div>
@endsection