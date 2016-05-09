@extends('app')
 
@section('content')
    <h2>Create Project</h2>
    <form action="{{ route('projects.store') }}" method="POST" class="form-group">
        @include('projects/partials/_form', ['submit_text' => 'Create Project'])
        
    </form>
@endsection