<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlogPost;
use App\Http\Requests\StorePost;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cache;
//use Illuminate\Support\Facades\DB;
use App\Models\User;
//use Illuminate\Support\Facades\Cache;

class PostsController extends Controller
{
    public function __construct(){
        $this->middleware('auth')->only(['create','store','edit','update','destroy']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        ini_set( 'memory_limit', '1048M' );
        ini_set('max_execution_time', '9999');
        //BlogPost::orderBy('create_at','desc')->take(5)->get();
        // DB::connection()->enableQueryLog();

        // $posts = BlogPost::with('comments')->get();

        // foreach ($posts as $post) {
        //     foreach ($post->comments as $comment) {
        //         echo $comment->content;
        //     }
        // }

        // dd(DB::getQueryLog());
        // $comments_all = Cache::remember('all_comments', 600, function () {
        //     return BlogPost::withCount('comments')->get();
        // });

        return view('post.index',
                    [
                        'posts' => BlogPost::LatesWithRelation()->get()
                    ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePost $request)
    {
        //dd($request);
        $validate = $request->validated();
        $validate['user_id'] = $request->user()->id;
        $post = BlogPost::create($validate);
        //$post = new BlogPost();
        // $post->title = $validate['title'];
        // $post->content = $validate['content'];
        //$post->fill();
        //$post->save();

        // $post2 = BlogPost::make();
        // $post2->save();
        // BlogPost::create();

        $request->session()->flash('status','the blog post was created!');

        return redirect()->route('posts.show',['post' => $post->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //abort_if(!isset($this->post[$id]),404);
        // return view('post.show',['post' => BlogPost::with(['comments' => function ($query) {
        //     return $query->latest();
        // }])->findOrFail($id)]);
        $blogpost = Cache::remember("blog-post-{$id}", 60, function () use ($id) {
            return BlogPost::with('comments','tags','user','comments.user')
            ->findOrFail($id);
        });
        $sessionid = session()->getid();
        $counterkey = "blog-post-{$id}-counter";
        $userkey = "blog-post-{$id}-users";

        $user = Cache::get($userkey,[]);
        $userupdate = [];
        $difference = 0;
        $now = now();
        //dd($user);
        foreach($user as $session => $lastvisit){
            if($now->diffInMinutes($lastvisit) >= 1){
                $difference --;
            } else {
                $userupdate[$session] = $lastvisit;
            }
        }

        if (
            !array_key_exists($sessionid,$user) ||
            ($now->diffInMinutes($user[$sessionid]) >= 1)
            ) {
            $difference++;
        }

        $userupdate[$sessionid] = now();
        Cache::forever($userkey,$userupdate);
        if(!Cache::has($counterkey)){
            Cache::forever($counterkey,1);
        } else {
            Cache::increment($counterkey,$difference);
        }
        

        $counter = Cache::get($counterkey);

        return view('post.show',['post' => $blogpost,'counter' => $counter]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //return "hola";
        $post = BlogPost::findOrFail($id);

        $this->authorize('update',$post);

        return view('post.edit',['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StorePost $request, $id)
    {
        $post = BlogPost::findOrFail($id);

        // if(Gate::denies('update-post',$post)){
        //     abort(403,'you cant edit this blog post');
        // }
        $this->authorize('update',$post);

        $validate = $request->validated();
        $post->fill($validate);
        $post->save();

        $request->session()->flash('status','Blogpost was update');

        return redirect()->route('posts.show',['post' => $post->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = BlogPost::findOrFail($id);

        // if(Gate::denies('delete-post',$post)){
        //     abort(403,'you cant delete this blog post');
        // }
        $this->authorize('delete',$post);

        $post->delete();

        session()->flash('status','Bloc post was deleted!');

        return redirect()->route('posts.index');
    }
}
