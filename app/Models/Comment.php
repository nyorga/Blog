<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'comment',
        'commentable_type',
        'commentable_id',
        'user_id'
    ];

    public function checkOwner($user_id)
    {
        return ($user_id == $this->user_id) ;
    }

    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }
}
