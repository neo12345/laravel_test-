@extends('layouts.app')

@section('content')

<h1>Welcome Home</h1>
<hr>

<a href="{{ route('tasks.index') }}" class="btn btn-info">View Tasks</a>
<a href="{{ route('news.index') }}" class="btn btn-info">View News</a>

@stop