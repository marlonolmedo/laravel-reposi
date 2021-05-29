@extends('layouts.app')

@section('title', 'blog post')

@section('content')
    {{-- @each('post.partials.post',$posts,'post') --}}
    <div class="row">
        <div class="col-8">
    @forelse ($posts as $key => $post)
    {{-- @break($key == 2)
    @continue($key == 1) --}}
        
            @include('post.partials.post')

    @empty 
        NO POST FOUND!
    @endforelse
    </div>
    <div class="col-4">
        @include('post._activity')
    </div>
    </div>
    
@endsection