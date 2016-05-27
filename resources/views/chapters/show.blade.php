@extends('layouts.app')

@section('content')
<div class="container">
    <a href="{{ route('comics.show', $comic->slug) }}" class="btn btn-info">Tro lai</a>
    <hr>
    
    @if(Gate::forUser($user)->allows('store', $auth))
    <div class="form-group">
        {{ Form::open([
            'method' => 'DELETE',
            'route' => ['comics.chapters.destroy', $comic->slug, $chapter->name],
        ]) }}
            <a href="{{ route('comics.chapters.edit', [$comic->slug, $chapter->name])}}" class="btn btn-warning">Chinh sua</a>
            {{ Form::submit('Xoa', ['class' => 'btn btn-danger']) }}
        {{ Form::close() }}
    </div>
    <hr>
    
    <div class="form-group">
        <a href="{{ route('comics.chapters.pages.create', [$comic->slug, $chapter->name]) }}" class="btn btn-primary">Them trang</a>
    </div>       
    @endif
    
    @foreach($chapter->pages as $page)
    <img class="img-responsive" src="{{ url('../storage/app/public').'/'.$page->link }}"/>
    @endforeach
    
    <div id="navigation" style="align-content: center">
        @if($prev)
        <a href="{{ route('comics.chapters.show', [$comic->slug, $prev->name]) }}" class="btn btn-lg btn-primary">Prev</a>
        @endif
        @if($next)
        <a href="{{ route('comics.chapters.show', [$comic->slug, $next->name]) }}" class="btn btn-lg btn-primary">Next</a>
        @endif
    </div>

    <div class="row">
        <div class="form-group error col-lg-6">
        {{ Form::open([
            'id' => 'frmComment',
            'method' => 'POST',
        ]) }}    
            
            {{ Form::hidden('chapter_id', $chapter->id, ['id' => 'chapter_id']) }}
            {{ Form::hidden('reply_to', 0, ['id' => 'reply_to']) }}
            @if($user)
                {{ Form::hidden('user_id', $user->id, ['id' => 'user_id']) }}
                {{ Form::hidden('username', $user->name, ['id' => 'username']) }}
            @endif
            {{ Form::label('comment', 'Comment: ', ['class' => 'label-control']) }}
            {{ Form::textarea('comment', null, ['class' => 'form-control', 'id' => 'comment']) }}
            <br>           
        {{ Form::close() }}
        <button id="btn-comment" name="comment" class="btn btn-primary btn-lg pull-right">Comment</button>
        </div>
    </div>
    <div class="row">
        <div class="form-group error col-lg-6" id="comment_list">
        @foreach($chapter->comment2s as $comment)
        <div id="comment{{ $comment->id }}" tabindex="-1">
            <div id="comment_username">
                <b>{{ $comment->username }}</b>
            </div>
            <br>
            
            <div id="comment_time">
                {{ $comment->created_at }}
            </div>
            <br>
            <br>
            
            @if($comment->comments->id != 0)
            <div id="comment_reply_to">
                Reply to: 
                <a href="#comment{{ $comment->comments->id }}">>>>{{ $comment->comments->id }}</a>
            </div>
                <br>
            @endif    
            
            @if($comment->replies->first())
            <div id="comment_replies">
                Replies: 
                @foreach($comment->replies as $reply)
                    <a href="#comment{{ $reply->id }}"><<<{{ $reply->id }},</a>
                @endforeach
            </div>    
            <br>
            @endif
            
            <br>
            <div id="comment_comment">
            {{ $comment->comment }}
            </div>
            <br>
            <button id="reply{{ $comment->id }}" class="btn btn-primary btn-lg pull-right reply" value="{{ $comment->id }}">Reply</button>
            {{ Form::open([
                'method' => 'DELETE',
                'route' => ['comment2s.destroy', $comment->id]
            ]) }}
                {{ Form::submit('Delete', ['class' => 'btn btn-danger'])}}
            {{ Form::close() }}
            <br>
            <br>
            <hr>
        </div>
        @endforeach
        </div>
    </div>
</div>

<meta name="_token" content="{!! csrf_token() !!}" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="{{asset('asset/js/comment2s.js')}}"></script>
@endsection