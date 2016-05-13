@extends('layouts.master')

@section('content')
  <div class="container-fluid">
    <div class="row page-title-row">
      <div class="col-md-12">
        <h3>Tags <small>» Create New Tag</small></h3>
      </div>
    </div>

    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">New Tag Form</h3>
          </div>
          <div class="panel-body">

              @if($errors->any())
              <ul class="danger">
                  <strong>Whoops!</strong>
                  There were some problems with your input.<br><br>
                  @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                  @endforeach
              </ul>
              @endif

            {{ Form::open([
                'route' => 'blog.tag.store',
                'method' => 'POST',
                'class' => 'form-horizontal'
            ]) }}    
              <input type="hidden" name="_token" value="{{ csrf_token() }}">

              <div class="form-group">
                <label for="tag" class="col-md-3 control-label">Tag</label>
                <div class="col-md-3">
                  <input type="text" class="form-control" name="tag" id="tag"
                         autofocus>
                </div>
              </div>

              @include('blog.tag._form')

              <div class="form-group">
                <div class="col-md-7 col-md-offset-3">
                  <button type="submit" class="btn btn-primary btn-md">
                    <i class="fa fa-plus-circle"></i>
                      Add New Tag
                  </button>
                </div>
              </div>

            {{ Form::close() }}

          </div>
        </div>
      </div>
    </div>
  </div>

@stop