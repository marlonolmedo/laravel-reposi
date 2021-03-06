<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function blogPosts(){
        return $this->hasMany('App\Models\BlogPost');
    }

    public function comments(){
        return $this->hasMany('App\Models\Comments');
    }

    public function scopeWithmostblogpost(Builder $query){
        return $query->withCount('blogPosts')->orderBy('blog_posts_count','desc');
    }

    public function scopeMostBlogPostLastMonth(Builder $query){
        return $query->withCount(['blogPosts' => function(Builder $query){
            $query->whereBetween(static::CREATED_AT,[now()->subMonths(1 ),now()]);
        }])
        ->having('blog_posts_count','>=',2)
        ->orderBy('blog_posts_count','desc');
    }
    
    //esta es una prueba de que si puedo descargar el mismo archivo pero de otro repo
}
