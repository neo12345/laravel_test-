@extends('layouts.app')

@section('content')
<div  class="container">
    <h3>Danh sach</h3>
    <hr>
    
    @if(Gate::forUser($user)->allows('store', $auth))
    <a href="{{ route('categories.create') }}" class="btn btn-primary">Tao moi</a>
    <hr>
    @endif
    
    <ul>
    @foreach($categories as $category)
    <li>
        <a href='{{ route('categories.show', $category->slug) }}'>{{ $category->name }}</a>
    </li>
    @endforeach
    </ul>
    {{ $categories->render()}}
</div>
@endsection