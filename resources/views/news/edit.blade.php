@extends('layouts.master')

@section('content')

    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    {!! Form::model($news, [
        'method' => 'PATCH',
        'route' => ['news.update', $news->id]
    ]) !!}
    @include('forms.form_news', ['text_submit' => 'Update news'])
    
@stop