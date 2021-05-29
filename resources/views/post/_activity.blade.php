<div class="container">
    <div class="row">
        <div class="card" style="width: 100%;">
            <img src="..." class="card-img-top" alt="...">
            <div class="card-body">
            <h5 class="card-title">Most Commented</h5>
            <p class="card-subtitle mb-2 text-muted">What people currently talking about</p>
            </div>
            <ul class="list-group list-group-flush">
                @foreach ($mostcommented as $post)
                    <li class="list-group-item">
                        <a href="{{ route('posts.show',['post' => $post->id]) }}">
                            {{ $post->title }}
                        </a>
                    </li>
                @endforeach
                
            </ul>
            {{-- <div class="card-body">
            <a href="#" class="card-link">Card link</a>
            <a href="#" class="card-link">Another link</a>
            </div> --}}
        </div>
    </div>
    <div class="row mt-4">
        <div class="card" style="width: 100%;">
            <img src="..." class="card-img-top" alt="...">
            <div class="card-body">
            <h5 class="card-title">Most Active</h5>
            <p class="card-subtitle mb-2 text-muted">User with most post writer</p>
            </div>
            <ul class="list-group list-group-flush">
                @foreach ($mostactive as $user)
                    <li class="list-group-item">
                            {{ $user->name }}
                    </li>
                @endforeach
                
            </ul>
            {{-- <div class="card-body">
            <a href="#" class="card-link">Card link</a>
            <a href="#" class="card-link">Another link</a>
            </div> --}}
        </div>
    </div>

    <div class="row mt-4">
        <div class="card" style="width: 100%;">
            <img src="..." class="card-img-top" alt="...">
            <div class="card-body">
            <h5 class="card-title">Most last mouth</h5>
            <p class="card-subtitle mb-2 text-muted">User with most post writer in the last moth</p>
            </div>
            <ul class="list-group list-group-flush">
                @foreach ($mostactivelastmounth as $user)
                    <li class="list-group-item">
                            {{ $user->name }}
                    </li>
                @endforeach
                
            </ul>
            {{-- <div class="card-body">
            <a href="#" class="card-link">Card link</a>
            <a href="#" class="card-link">Another link</a>
            </div> --}}
        </div>
    </div>
</div>