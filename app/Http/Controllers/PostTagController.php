<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Tag;

class PostTagController extends Controller
{
    public function index($tag){
        $tag = Tag::findOrFail($tag);

        return view('post.index',['posts' => $tag->BlogPost()
                                                    ->LatesWithRelation()
                                                    ->get()]);
    }
}
