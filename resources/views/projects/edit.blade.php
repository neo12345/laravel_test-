@extends('app')
 
@section('content')
    <h2>Edit Project</h2>
 
    <form action="{{ route('projects.update', $project->slug) }}" method="PATCH" class="form-group" >
        @include('projects/partials/_form', ['submit_text' => 'Edit Project'])
    </form>
@endsection