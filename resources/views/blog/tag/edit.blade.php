@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <div class="row page-title-row">
        <div class="col-md-12">
            <h3>Tags <small>» Edit Tag</small></h3>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Tag Edit Form</h3>
                </div>
                <div class="panel-body">

                    @if($errors->any())
                    <ul>
                        <div class="danger">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </div>
                    </ul>
                    @endif

                    {{ Form::open([
                        'method' => 'PUT',
                        'route' => ['blog.tag.update', $tag->id],
                        'class' => 'form-horizontal'
                    ]) }}    
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="id" value="{{ $tag->id }}">

                    <div class="form-group">
                        <label for="tag" class="col-md-3 control-label">Tag</label>
                        <div class="col-md-3">
                            <input type="text" class="form-control disabled" 
                                   name="tag" id="tag" value="{{ $tag->tag }}">
                        </div>
                    </div>

                    @include('blog.tag._form')

                    <div class="form-group">
                        <div class="col-md-7 col-md-offset-3">
                            <button type="submit" class="btn btn-primary btn-md">
                                <i class="fa fa-save"></i>
                                Save Changes
                            </button>
                            <button type="button" class="btn btn-danger btn-md"
                                    data-toggle="modal" data-target="#modal-delete">
                                <i class="fa fa-times-circle"></i>
                                Delete
                            </button>
                        </div>
                    </div>

                    {{ Form::close() }}

                </div>
            </div>
        </div>
    </div>
</div>

{{-- Confirm Delete --}}
<div class="modal fade" id="modal-delete" tabIndex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    ×
                </button>
                <h4 class="modal-title">Please Confirm</h4>
            </div>
            <div class="modal-body">
                <p class="lead">
                    <i class="fa fa-question-circle fa-lg"></i>  
                    Are you sure you want to delete this tag?
                </p>
            </div>
            <div class="modal-footer">

                {{ Form::open([
                    'method' => 'DELETE',
                    'route' => ['blog.tag.destroy', $tag->id],
                  ]) }}
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="_method" value="DELETE">
                <button type="button" class="btn btn-default"
                        data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-danger">
                    <i class="fa fa-times-circle"></i> Yes
                </button>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>

@endsection