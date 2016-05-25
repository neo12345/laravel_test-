@extends('layouts.app')

@section('content')
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
            <p>
                Categories: 
            <hr>
            @foreach($comic->categories as $category)
            <a href='{{ route('categories.show', $category->slug) }}'>{{ $category->name }}</a>, 
            @endforeach

            @if(Gate::forUser($user)->allows('store', $auth))
            <hr>
            <a href="{{ route('comics.editCategory', $comic->slug) }}" class="btn btn-warning">Sua category</a>
            @endif
            </p>
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
</div>
@endsection