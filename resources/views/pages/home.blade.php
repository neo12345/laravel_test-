@extends('layouts.app')

@section('content')

<h1>Welcome Home</h1>
<hr>

<a href="{{ route('tasks.index') }}" class="btn btn-info">View Tasks</a>
<a href="{{ route('news.index') }}" class="btn btn-info">View News</a>

<div class="row">
    <div class="col-md-8">
        <h1 class="text-primary" >{{ trans('message.heading') }}</h1>
    	<?php App::setLocale('es'); ?>
        <h1 class="text-primary" >{{ trans('message.heading') }}</h1>
    </div>
</div>

@stop