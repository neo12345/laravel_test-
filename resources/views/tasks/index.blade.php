@extends('layouts.app')

@section('content')

<h1>Task List</h1>
<p class="lead">Here's a list of all your tasks. <a href="{{ route('tasks.create') }}">Add a new one?</a></p>
<hr>
@foreach($tasks as $task)
    <h3>{{ $task->task }}</h3>
    <p>{{ $task->description}}</p>
    <p>
        <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-info">View Task</a>
        <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-primary">Edit Task</a>
    </p>
    <hr>
@endforeach
<a href="{{ route('tasks.create') }}">Add a new one?</a>
@stop