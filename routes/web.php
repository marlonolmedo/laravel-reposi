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

Route::get('/', function () {
    return view('welcome');
})->name('home.index');

Route::get('/contact', function () {
    return 'conatct';
})->name('home.contact');

Route::get('/post/{id}', function ($id) {
    return 'blog post '.$id;
})
// ->where([
//     'id' => '[0-9]+'
// ])
->name("post.show");

Route::get('/resent-post/{id?}', function ($daysago = 20) {
    return 'post from '.$daysago .' days ago';
})->name("post.recent.index");
