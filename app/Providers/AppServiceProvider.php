<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Blade;
use App\Http\ViewComposers\ActivityComposer;

class AppServiceProvider extends ServiceProvider
{
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        'App\BlogPost' => 'App\Policies\BlogPostPolicy'
    ];
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Gate::define('home.secret',function($user){
            return $user->is_admin;
        });
        // Gate::define('update-post',function ($user, $post) {
        //     return $user->id == $post->user_id;
        // });

        // Gate::define('delete-post',function ($user, $post) {
        //     return $user->id == $post->user_id;
        // });

        // Gate::define('posts.update','App\Policies\BlogPostPolicy@update');
        // Gate::define('posts.delete','App\Policies\BlogPostPolicy@delete');

        // Gate::resource('posts','App\Policies\BlogPostPolicy');

        Gate::before(function ($user, $ability) {
            if($user->is_admin && in_array($ability,['update'])){
                return true;
            }
        });

        Blade::component('components.badge','badge');
        Blade::component('components.updated','updated');
        Blade::component('components.tags','tags');
        Blade::component('components.errors','errors');

        view()->composer(['post.index','post.show'],ActivityComposer::class);

        // Gate::after(function ($user, $ability,$result) {
        //     if($user->is_admin && in_array($ability,['update-post'])){
        //         return true;
        //     }
        // });
    }
}
