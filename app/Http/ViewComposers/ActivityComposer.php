<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Cache;
use App\Models\BlogPost;
use App\Models\User;

class ActivityComposer {

    public function compose(View $view){
        $mostcommented = Cache::remember('mostcommented', now()->addSeconds(10),function (){
            return BlogPost::mostcommented()->take(5)->get();
        });

        $mostactive = Cache::remember('mostactive', now()->addSeconds(10),function (){
            return User::withmostblogpost()->take(5)->get();
        });

        $mostactivelastmount = Cache::remember('mostactivelastmount', now()->addSeconds(10),function (){
            return User::MostBlogPostLastMonth()->take(5)->get();
        });

        $view->with('mostcommented', $mostcommented);
        $view->with('mostactive', $mostactive);
        $view->with('mostactivelastmounth', $mostactivelastmount);
    }

}