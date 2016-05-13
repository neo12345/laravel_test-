@extends('layouts.master');

@section('content')
    <table>
        @foreach($posts as $post)
        <tr>
            <td>
                <img src="{{ $post->feature_image }}" width="200px"/>
            </td>
            <td>
                <h3><a href="{{ route('blog.posts.show', $post->id) }}">{{ $post->title }}</a></h3>
                <p>{{ $post->description }}</p>
            </td>
        </tr>
        @endforeach
    </table>

{{  $posts->render() }}
@endsection