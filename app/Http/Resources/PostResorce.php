<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResorce extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'title'=>$this->title,
            'body'=>$this->body,
            'view'=>$this->view,
            'like'=>$this->like,
            'dislike'=>$this->dislike,
            'comments'=>PostCommentResource::collection($this->accepted_comments),
            'user'=>UserResource::make(User::find($this->user_id))->jsonSerialize()['name'],
            'likes' => UserResource::collection(User::query()->whereIn('id',$this->likes()->pluck('user_id'))->get()),
            'dislikes' => UserResource::collection(User::query()->whereIn('id',$this->dislikes()->pluck('user_id'))->get()),
        ];
    }
}
