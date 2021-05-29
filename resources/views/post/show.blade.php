@extends('layouts.app')

@section('title', $post->title)

@section('content')
<div class="row">
    <div class="col-8">
{{-- @if($post["is_new"])
    <div>New block post! using if</div>
@elseif(!$post["is_new"])
    <div>old block post! using if</div>
@endif

    @unless ($post["is_new"])
        <div>this is a old post using unless</div>
    @endunless --}}

    <h1>{{ $post->title }}
        {{-- @if (now()->diffInMinutes($post->created_at) < 200) --}}
        {{-- @badge(['type' => 'primary'])
            Brand new post!
        @endbadge --}}
        @php
            $color = 'primary';
        @endphp
        <x-badge :type="$color" :show="(now()->diffInMinutes($post->created_at) < 5)">
            Brand new post!
        </x-badge>
    {{-- @endif --}}
    </h1>
    <p>{{ $post->content }}</p>
    {{-- <p>Added {{ $post->created_at->diffForHumans() }}</p> --}}
    <x-updated :date="$post->created_at" :name="$post->user->name">
    </x-updated>
    <x-updated :date="$post->updated_at">
        Updated
    </x-updated>

    <x-tags :tags="$post->tags"/>
    
    <p>Currently read by {{ $counter }} people</p>

    <h4>Comments</h4>

        @include('comments._form')

    @forelse ($post->comments as $comment)
        <p>
            {{ $comment->content }}
        </p>
        {{-- <p class="text-muted">
            added {{ $comment->created_at->diffForHumans() }}
        </p> --}}

        <x-updated :date="$comment->created_at" :name="$comment->user->name">
        </x-updated>
    @empty
        <p>No comments yet!</p>
    @endforelse
    {{-- @isset($post['has_comments'])
        <div>the post has come comments using iset</div>
    @endisset --}}
    </div>
    <div class="col-4">
        @include('post._activity')
    </div>
</div>
@endsection