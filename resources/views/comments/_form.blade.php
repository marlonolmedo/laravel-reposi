<div class="mb-2 mt-2">
    @auth
    <form method="POST" action="{{ route('posts.comments.store',['post' => $post->id]) }}">
        @csrf
        <div class="form-group">
            <textarea class="form-control" name="content" id="content" ></textarea>
        </div>

        <div>
            <button type="submit" value="create" class="btn btn-primary btn-block">add comments!</button>
        </div>
    </form>
    @else
    <a href="{{ route('login') }}">sing-in</a> to post comments!
    @endauth
</div>
<hr/>
