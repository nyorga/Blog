<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Post extends Model
{
    protected $fillable=[
        'title',
        'body',
        'view',
        'user_id'
    ];

    use HasFactory;

    public function checkOwner($user_id)
    {
        return ($user_id == $this->user_id) ;
    }

    public function likes()
    {
        return $this->hasMany(PostLike::class);
    }

    public function dislikes()
    {
        return $this->hasMany(PostDisLike::class);
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }



    public function increaseView()
    {
        $this->update([ 'view'=>$this->view+1 ]);
    }

    public function getLikeAttribute()
    {
        return $this->likes()->count();
    }

    public function getDislikeAttribute()
    {
        return $this->dislikes()->count();
    }

    public function getAcceptedCommentsAttribute()
    {
        return $this->comments->where('accepted', '=', 1);
    }
}
