@extends('layouts.master');

@section('content')
<a href="{{ route('blog.posts.create')}}"><button name="btn-add" class="btn btn-primary">Add New Post</button></a>

<table class="table-hover">
    <thead>
    <th width="250px">Title</th>
    <th width="400px">Description</th>
    <th width="200px">Detail</th>
</thead>
<tbody  id="posts-list" name="posts-list">
@foreach($posts as $post)
<tr id="post{{$post->id}}" height="100px">
    <td>
        <b>{{ $post->title }}</b>
    </td>
    <td>{{ $post->description }}</td>
    <td>
        <button class="btn btn-warning btn-detail open-modal" id='btn-add' value="{{ $post->id }}">Quick Edit</button>
        <button class="btn btn-danger btn-delete delete-post" id='btn_delete' value="{{ $post->id }}">Delete</button>
    </td>
</tr>
@endforeach
</tbody>
</table>

{!! $posts->render() !!}

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">Blog Editor</h4>
            </div>
            
            <div class="modal-body">
                <form id="formPosts" name="formPosts" class="form-horizontal" novalidate="" enctype="multipart/form-data">

                    <div class="form-group">
                        <label for="TitlePosts" class="col-sm-3 control-label">Title</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control has-error" id="title" name="title" placeholder="Title" value="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Description" class="col-sm-3 control-label">Description</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="description" name="description" placeholder="Description" value="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Content" class="col-sm-3 control-label">Content</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" id="content" name="content"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-save" value="add">Save changes</button>
                <input type="hidden" id="post_id" name="post_id" value="0">
            </div>
        </div>
    </div>
</div>
</div>
</div>
<meta name="_token" content="{!! csrf_token() !!}" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="{{asset('asset/js/ajax-blog-posts.js')}}"></script>
@endsection