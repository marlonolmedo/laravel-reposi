<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlogPost;
use App\Http\Requests\StorePost;
//use Illuminate\Support\Facades\DB;

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
        //BlogPost::orderBy('create_at','desc')->take(5)->get();
        // DB::connection()->enableQueryLog();

        // $posts = BlogPost::with('comments')->get();

        // foreach ($posts as $post) {
        //     foreach ($post->comments as $comment) {
        //         echo $comment->content;
        //     }
        // }

        // dd(DB::getQueryLog());

        return view('post.index',
                    ['posts' => BlogPost::withCount('comments')->get()]
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
        return view('post.show',['post' => BlogPost::with('comments')->findOrFail($id)]);
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
        return view('post.edit',['post' => BlogPost::findOrFail($id)]);
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
        $post->delete();

        session()->flash('status','Bloc post was deleted!');

        return redirect()->route('posts.index');
    }
}
