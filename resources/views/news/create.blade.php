@extends('layouts.app')

@section('content')

    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif
    Create news will be queued!
    {!! Form::open([
        'route' => 'news.store'
    ]) !!}
    @include('forms.form_news', ['text_submit' => 'Create news'])
    
@stop