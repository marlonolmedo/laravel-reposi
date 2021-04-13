@extends('layouts.app')

@section('title', $post["title"])

@section('content')
@if($post["is_new"])
    <div>New block post! using if</div>
@elseif(!$post["is_new"])
    <div>old block post! using if</div>
@endif

    @unless ($post["is_new"])
        <div>this is a old post using unless</div>
    @endunless

    <h1>{{ $post["title"] }}</h1>
    <p>{{ $post["content"] }}</p>

    @isset($post['has_comments'])
        <div>the post has come comments using iset</div>
    @endisset
@endsection