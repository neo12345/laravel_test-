<div class="form-group error col-lg-6" id="comment_list">
@foreach($comment2s as $comment)
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