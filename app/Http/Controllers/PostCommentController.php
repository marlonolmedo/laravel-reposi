<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreComment;
use App\Models\BlogPost;

class PostCommentController extends Controller
{

    public function __construct(){
        $this->middleware('auth')->only(['Store']);
    }

    public function Store(BlogPost $post,StoreComment $request){
        $post->comments()->create([
            'content' => $request->input('content'),
            'user_id' => $request->user()->id
        ]);
        $request->session()->flash('status','the Comment post was created!');

        return redirect()->back();
    }
}
