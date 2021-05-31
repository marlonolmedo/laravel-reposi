<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Scope\LatestScope;
use App\Scope\DeletedAdminScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;

class BlogPost extends Model
{
    protected $fillable = ['title','content','user_id'];
    use HasFactory;
    use SoftDeletes;
    
    public function comments(){
        return $this->hasMany('App\Models\Comment')->latest();
    }
    public function user(){
        return $this->belongsTo('App\Models\User');
    }
    public function tags(){
        return $this->belongsToMany('App\Models\Tag')->withTimestamps();
    }
    public function image(){
        return $this->hasOne('App\Models\Image');
    }

    public function scopeLates(Builder $query){
        return $query->orderBy(static::CREATED_AT,'desc');
    }

    public function scopeMostcommented(Builder $query){
        return $query->withCount('comments')->orderby('comments_count','desc');
    }

    public function scopeLatesWithRelation(Builder $query){
        return $query
        ->latest()
        ->withCount('comments')
        ->with('user')
        ->with('tags');
    }

    public static function boot(){

        static::addGlobalScope(new DeletedAdminScope);
        
        parent::boot();

        static::deleting(function (BlogPost $blogpost){
            $blogpost->comments()->delete();
            //$blogpost=>image()->delete();
        });

        static::updating(function (BlogPost $blogpost){
            Cache::forget("blog-post-{$blogpost->id}");
        });

        static::restoring(function (BlogPost $blogpost){
            $blogpost->comments()->restore();
        });
    }
}
