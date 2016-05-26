@extends('layouts.app')

@section('content')
<input type="hidden" value="{{ $comic->slug }}" id="comic_slug">
<div class="container">
    <div class="row">
        <div class="thumbnail col-md-3">
            <img src="{{ $comic->image }}"/>

            @if(Gate::forUser($user)->allows('store', $auth))
            <p>
            <div class="form-inline">
                {{ Form::open([
                'method' => 'DELETE',
                'route' => ['comics.destroy', $comic->slug],        
            ]) }}
                <a href="{{ route('comics.edit', $comic->slug) }}" class="btn btn-warning">Chinh sua</a>
                {{ Form::submit('Xoa', ['class' => 'btn btn-danger']) }}
                {{ Form::close() }}
            </div>
            </p>
            @endif
        </div>

        <div class="col-md-6">
            <h3>{{ $comic->name }}</h3>
            <p>{{ $comic->description }}</p>
            <p>Categories: 
            <hr>
            @foreach($comic->categories as $category)
            <a href='{{ route('categories.show', $category->slug) }}'>{{ $category->name }}</a>, 
            @endforeach

            @if(Gate::forUser($user)->allows('store', $auth))
                <hr>
                <a href="{{ route('comics.editCategory', $comic->slug) }}" class="btn btn-warning">Sua category</a>
            @endif
            </p>
            
            <div id="like_counter">Like counter: {{ count($comic->like) }}</div>
            @can('store', $auth)
                @if( $comic->like->contains($user->id))
                    <button id="btn_like" class="btn btn-lg btn-primary">Unlike</button>
                @else
                    <button id="btn_like" class="btn btn-lg btn-primary">Like</button>
                @endif
            @endcan
        </div>
    </div>
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading"><b>Danh sach tap</b></div>
            <div class="panel-body">
                @if(Gate::forUser($user)->allows('store', $auth))
                <p>
                    <a href="{{ route('comics.chapters.create', $comic->slug)}}" class="btn btn-primary">Tao moi</a>
                </p>
                @endif


                <ul>
                    @foreach($comic->chapters as $chapter)
                        @if($chapter->publish == 1)                           
                        <li><a href='{{ route('comics.chapters.show', [$comic->slug, $chapter->name]) }}'>{{ $chapter->name }}</a></li>                          
                            @if(Gate::forUser($user)->allows('store', $auth))
                                <div class="pull-right">
                                    Da xuat ban
                                </div>
                            @endif
                        <hr>    
                        @else
                            @if(Gate::forUser($user)->allows('store', $auth))                               
                                <li><a href='{{ route('comics.chapters.show', [$comic->slug, $chapter->name]) }}'>{{ $chapter->name }}</a></li>                                
                                <div class="pull-right">
                                    Chua xuat ban
                                </div>
                            @endif
                            <hr>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="form-group error col-lg-6">
        {{ Form::open([
            'id' => 'frmComment',
            'method' => 'POST',
        ]) }}    
            
            {{ Form::hidden('comic_id', $comic->id, ['id' => 'comic_id']) }}
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
        @foreach($comic->comments as $comment)
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
            
            @if($comment->comments)
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
<script src="{{asset('asset/js/comments.js')}}"></script>
<script src="{{asset('asset/js/like.js')}}"></script>
@endsection
