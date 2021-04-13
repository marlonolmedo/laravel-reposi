@extends('layouts.app')

@section('title', 'blog post')

@section('content')
    {{-- @each('post.partials.post',$posts,'post') --}}
    @forelse ($posts as $key => $post)
    {{-- @break($key == 2)
    @continue($key == 1) --}}
    @include('post.partials.post')

    @empty 
        NO POST FOUND!
    @endforelse
    
@endsection