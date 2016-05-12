@extends('layouts.app')

@section('content')

    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    {{ Form::open([
        'method' => 'POST',
        'action' => 'EmailsController@send',
        'class' => 'form-group',
        'files' => true
    ])}}
        {{ Form::label('name', 'Name: ', ['class' => 'label-control']) }}
        {{ Form::text('name', 'Test Laravel', ['class' => 'form-control']) }}
        <hr>
        {{ Form::label('receiver', 'Receiver: ', ['class' => 'label-control']) }}
        {{ Form::text('receiver', null, ['class' => 'form-control']) }}
        <hr>
        {{ Form::label('replyTo', 'Reply to: ', ['class' => 'label-control']) }}
        {{ Form::text('replyTo', config('mail.username'), ['class' => 'form-control']) }}
        <hr>
        {{ Form::label('subject', 'Subject: ', ['class' => 'label-control']) }}
        {{ Form::text('subject', null, ['class' => 'form-control']) }}
        <hr>
        {{ Form::label('body', 'Body: ', ['class' => 'label-control']) }}
        {{ Form::textarea('body', null, ['class' => 'form-control']) }}
        <hr>
        {{ Form::label('attach', 'Attach: ', ['class' => 'label-control']) }}
        {{ Form::file('attach', ['class' => 'form-control']) }}
        <hr>
        {{ Form::submit('Send', ['class' => 'btn btn-primary']) }}
    {{ Form::close()}}
@endsection