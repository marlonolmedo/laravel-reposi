<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\PostsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// })->name('home.index');
$post = [
    1 => [
        'title' => 'intro to laravel',
        'content' => 'this is a short into laravel',
        'is_new' => true,
        'has_comments' => true
    ],
    2 => [
        'title' => 'intro to php',
        'content' => 'this is a short intro to PHP',
        'is_new' => false
    ],
    3 => [
        'title' => 'intro to golang',
        'content' => 'this is a short intro to golang',
        'is_new' => false
    ]
];

Route::get('/', [HomeController::class,'home'])
->name('home.index');
//->middleware('auth');

Route::get('/contact', [HomeController::class,'contact'])->name('home.contact');

Route::get("/single", AboutController::class);

Auth::routes();

// Route::view('/','home.index')->name('home.index');
// Route::view('/contact','home.contact')->name('home.contact');

Route::resource('posts', PostsController::class);
//->except('index')
// Route::get("/posts/{id?}", [PostsController::class,'index'])->name('posts.index');
//->only(['index','show','create','store','edit','update']);
//Route::resource('posts', PostsController::class)->except(['index','show']);

// Route::get('/posts', 
//     //function (Request $request) use ($post) {
//     function () use ($post) {
//     //dd(request()->all());
//     dd((int)request()->input('page',65));
//     //abort_if(!isset($post]),404);
//     return view('post.index',['posts' => $post]);
// })
// ->name("post.index");

// Route::get('/post/{id}', function ($id) use ($post) {
    
//     abort_if(!isset($post[$id]),404);
//     return view('post.show',['post' => $post[$id]]);
// })
// // ->where([
// //     'id' => '[0-9]+'
// // ])
// ->name("post.show");

// Route::get('/resent-post/{id?}', function ($daysago = 20) {
//     return 'post from '.$daysago .' days ago';
// })->name("post.recent.index");


Route::prefix("/fun")->name("fun.")->group(function () use ($post){
    Route::get("/fun/responses", function() use ($post) {
        return response($post,201)
                ->header('Content-Type','application/json')->cookie('MY_COOKIE','marlon',3600);
    })->name('response');
    
    Route::get("/redirect", function() {
        return redirect('/contact');
    })->name('redirect');
    
    Route::get("/back", function() {
        return back();
    })->name('back');
    
    Route::get("/named-route", function() {
        return redirect()->route('post.show',['id' => 1]);
    })->name('named-route');
    
    Route::get("/away", function() {
        return redirect()->away('https://www.google.com/');
    })->name('away');
    
    Route::get("/json", function() use ($post) {
        return response()->json($post);
    })->name('json');
    
    Route::get("/dowload", function() use ($post) {
        return response()->download(public_path('/gato.png',"dgato.png"));
    })->name('dowload');

});
