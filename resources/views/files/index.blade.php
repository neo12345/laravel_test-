@extends('layouts.app')

@section('content')

    {{ Form::open([
        'method' => 'POST',
        'action' => 'FilesController@add',
        'files' => true,
        'class' => 'form-group'
    ]) }}
        {{ Form::label('uploadfile', 'Uploadfile: ', ['class' => 'control-label']) }}
        {{ Form::file('filefield', ['class' => 'form-control']) }}
        {{ Form::submit('Upload', ['class' => 'btn btn-primary']) }}
    {{ Form::close() }}
    
    <hr>
    <b>Load from cache</b>
    
    <ul class="thumbnails">    
        @foreach($files as $file)
            <div class="col-md-2">
                <div class="thumbnail" id="file{{ $file->filename }}">
                    <img src="{{route('getentry', $file->filename)}}" alt="ALT NAME" class="img-responsive" />
                    <div class="caption">
                        <p>{{$file->original_filename}}</p>
                    </div>
                    
                    {{ Form::open([
                        'method' => 'DELETE',
                        'route' => ['deleteentry', $file->filename]
                    ]) }}
                        {{ Form::submit('Delete', ['class' => 'btn btn-danger', 'data-id' => $file->filename]) }}
                    {{ Form::close() }}
                    <button class="btn btn-warning" id="btn_delete" value="{{ $file->filename }}">Delete ajax</button>
                    
                    {{ Form::open([
                        'method' => 'GET',
                        'route' => ['downloadentry', $file->filename]
                    ]) }}
                        {{ Form::submit('Download', ['class' => 'btn btn-info']) }}
                    {{ Form::close() }}
                </div>
            </div>
        @endforeach
    </ul>
    <meta id="token" name="token" content="{{ csrf_token() }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script language="JavaScript" type="text/javascript" src="{{asset('asset/js/ajax-files.js')}}"></script>
@stop