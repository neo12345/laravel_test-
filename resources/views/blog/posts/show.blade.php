@extends('layouts.master');

@section('content')
<table border='0'>
    <td><img src="{{ $post->feature_image }}" width="200px"</td>
    <td>
        <h3>{{ $post->title }}</h3>
        <b>{{ $post->description }}</b>
    </td>
</table>
<hr>
<p>{{ $post->content }}</p>
@endsection