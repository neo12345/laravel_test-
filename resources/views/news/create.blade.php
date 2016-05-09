@extends('layouts.master')

@section('content')

    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    {!! Form::open([
        'route' => 'news.store'
    ]) !!}
    @include('forms.form_news', ['text_submit' => 'Create news'])
    
@stop