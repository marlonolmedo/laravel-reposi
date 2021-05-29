<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Comment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['user_id','content'];

    public function blogPost(){
        //return $this->belongsTo('App\Models\BlogPost', 'post_id', 'blog_post_id');
        return $this->belongsTo('App\Models\BlogPost');
    }

    public function scopeLates(Builder $query){
        return $query->orderBy(static::CREATED_AT,'desc');
    }

    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}
