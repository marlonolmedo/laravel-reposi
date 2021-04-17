@extends('layouts.app')

@section('title', 'Update the post')

@section('content')
    <form action="{{ route('posts.update',['post' => $post->id]) }}" method="POST">
        @csrf
        @method('PUT')
        @include('post.partials.form')
        <div><input type="submit" value="update" class="btn btn-primary btn-block"></div>
    </form>
    
@endsection