@extends('app')

@section('content')
    <h2>Projects</h2>
 
    @if ( !$projects->count() )
        You have no projects
    @else
        <ul>
            @foreach( $projects as $project )
                <li>
                    <a href="{{ route('projects.show', $project->slug) }}">{{ $project->name }}</a>
                    
                    <form action="{{ route('projects.destroy', $project->slug) }}" method="DELETE">
                    <a href="{{ route('projects.edit', $project->slug) }}" class="btn btn-info">Edit</a>
                    <!--<a href="{{ route('projects.destroy', $project->slug) }}" class="btn btn-danger">Delete</a>-->
                    <input type="submit" value="Delete" class="btn btn-danger"/>
                    </form>
                </li>
            @endforeach
        </ul>
    @endif
    
    <p>
        <a href="{{ route('projects.create', 'Create Project') }}">Create</a>
    </p>
@endsection

