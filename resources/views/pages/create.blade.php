@extends('layouts.app')

@section('content')
<a href="{{ route('comics.chapters.show', [$comic->slug, $chapter->name]) }}" class="btn btn-info btn-lg">Tro lai</a>
<hr>
<button id="btn-add" name="btn-add" class="btn btn-primary btn-lg">Them moi</button>
<hr>
<input type="hidden" id="comic_slug" name="comic_slug" value="{{ $comic->slug }}">
<input type="hidden" id="chapter_name" name="chapter_name" value="{{ $chapter->name }}">
<div id="pages-list" name="pages-list">
    @foreach($chapter->pages as $page)
    <div id="page{{ $page->id }}">
            <div class="thumbnail col-lg-2">
                <img src="{{ url('../storage/app/public').'/'.$page->link }}" />
                <hr>
                <button class="btn btn-warning btn-lg btn-detail open-modal" value="{{ $page->id }}">Chinh sua</button>
                <button class="btn btn-danger btn-lg btn-delete delete-page" value="{{ $page->id }}">Xoa</button>
            </div>
    </div>
    @endforeach
</div>

<div class="modal fade"  id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">PageForm</h4>
            </div>
            <div class="modal-body">
                <form id="frmPages" name="frmPages" class="form-horizontal" enctype="multipart/form-data">

                    <div class="form-group error">
                        <input type="hidden" id="comic_slug" name="comic_slug" value="{{ $comic->slug }}">
                        <input type="hidden" id="chapter_name" name="chapter_name" value="{{ $chapter->name }}">
                        <label for="inputPage" class="col-sm-3 control-label">File</label>
                        <div class="col-sm-9">
                            <input type="file" class="form-control has-error" id="file" name="file">
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-save" value="add">Add</button>
                <input type="hidden" id="page_id" name="page_id" value="0">
            </div>
        </div>
    </div>
</div>

<meta name="_token" content="{!! csrf_token() !!}" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="{{asset('asset/js/pages.js')}}"></script>
@endsection