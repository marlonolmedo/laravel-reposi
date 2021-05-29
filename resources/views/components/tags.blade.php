<p>
    @foreach ($tags as $tag)
        <a href="{{ route('posts.tags.index',['tag' => $tag->id]) }}" 
        class="badge badge-success badge">{{ $tag->name }}</a>
    @endforeach
</p>