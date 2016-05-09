@extends('app')

@section('content')
    <h2>{{ $project->name }}</h2>
 
    @if ( !$project->tasks->count() )
        Your project has no tasks.
    @else
        <ul>
             @foreach( $project->tasks as $task )
                <li>
                    <a href="{{ route('projects.tasks.show', [$project->slug, $task->slug]) }}">{{ $task->name }}</a>
                    <a href="{{ route('projects.tasks.edit', [$project->slug, $task->slug])}}" class="btn btn-info">Edit</a>
                    <a href="{{ route('projects.tasks.destroy', [$project->slug, $task->slug])}}" class="btn btn-danger">Delete</a>
                </li>
            @endforeach
        </ul>
    @endif
    
    <p>
        <a href="{{ route('projects.index') }}">Back to projects</a> |
        <a href="{{ route('projects.tasks.create', $project->slug) }}">Create Task</a>
    </p>
    
@endsection