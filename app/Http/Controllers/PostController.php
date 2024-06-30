<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeletePostRequest;
use App\Http\Requests\DislikePostRequest;
use App\Http\Requests\LikePostRequest;
use App\Http\Requests\PostCommentRequest;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResorce;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return PostResorce::collection(Post::query()->latest()->paginate());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = auth()->user()->id;
        $post = Post::create($validated);
        return PostResorce::make(Post::find($post->id));

    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $post->increaseView();
        return PostResorce::make($post);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $user = auth()->user();
        if($post->checkOwner($user->id)) {
            $validated = $request->validated();
            $post->update($validated);
            return PostResorce::make($post);
        }
        return response()->json(['massage'=>'This post is not yours']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeletePostRequest $request, Post $post)
    {
        $user = auth()->user();
        if($post->checkOwner($user->id)) {
            $post->delete();
            return response()->json(['massage'=>'Post deleted successfully!']);
        }
        return response()->json(['massage'=>'This post is not yours']);
    }

    public function like(LikePostRequest $request, Post $post)
    {
        $user = auth()->user();
        $user_has_already_liked_this_post = $post->likes()->where('user_id','=',$user->id)->first();
        if($user_has_already_liked_this_post){
            $user_has_already_liked_this_post->delete();
        }
        else {
            $post->disLikes()->where('user_id', '=', $user->id)->delete();
            $post->likes()->create(['user_id' => $user->id]);
        }
        return PostResorce::make($post);

    }

    public function disLike(DislikePostRequest $request, Post $post)
    {
        $user = auth()->user();
        $user_has_already_disliked_this_post = $post->disLikes()->where('user_id', '=', $user->id)->first();
        if($user_has_already_disliked_this_post){
            $user_has_already_disliked_this_post->delete();
        }
        else {
            $post->likes()->where('user_id', '=', $user->id)->delete();
            $post->dislikes()->create(['user_id' => $user->id]);
        }
        return PostResorce::make($post);

    }

    public function submitComment(PostCommentRequest $request, Post $post)
    {
        $user = auth()->user();
        $validated = $request->validated();
        $validated['user_id'] = $user->id;
        $post->comments()->create($validated);
        return response()->json(['message' => 'comment submitted successfully!!!']);

    }
}
