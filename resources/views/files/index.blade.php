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
    <ul class="thumbnails">
        @foreach($files as $file)
            <div class="col-md-2">
                <div class="thumbnail">
                    <img src="{{route('getentry', $file->filename)}}" alt="ALT NAME" class="img-responsive" />
                    <div class="caption">
                        <p>{{$file->original_filename}}</p>
                    </div>
                    
                    {{ Form::open([
                        'method' => 'DELETE',
                        'route' => ['deleteentry', $file->filename]
                    ]) }}
                        {{ Form::submit('Delete', ['class' => 'btn btn-danger']) }}
                    {{ Form::close() }}
                    
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
@stop