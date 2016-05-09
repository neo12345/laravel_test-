@extends('app')
 
@section('content')
    <h2>
        <a href="{!! route('projects.show', $project->name, [$project->slug]) !!}">{{ $project->name }}</a>
        <br>
        {{ $task->name }}
    </h2>
    task
    {{ $task->description }}
@endsection