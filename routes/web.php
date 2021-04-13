<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('home.index',[]);
// })->name('home.index');

// Route::get('/contact', function () {
//     return view('home.contact');;
// })->name('home.contact');

Route::view('/','home.index')->name('home.index');
Route::view('/contact','home.contact')->name('home.contact');

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

Route::get('/posts', function () use ($post) {
    
    //abort_if(!isset($post]),404);
    return view('post.index',['posts' => $post]);
})
->name("post.index");

Route::get('/post/{id}', function ($id) use ($post) {
    
    abort_if(!isset($post[$id]),404);
    return view('post.show',['post' => $post[$id]]);
})
// ->where([
//     'id' => '[0-9]+'
// ])
->name("post.show");

Route::get('/resent-post/{id?}', function ($daysago = 20) {
    return 'post from '.$daysago .' days ago';
})->name("post.recent.index");
