<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        $user = auth()->user();
        if($comment->checkOwner($user->id)) {
            $validated = $request->validated();
            $comment->update($validated);
            return response()->json(['massage' => 'Comment updated successfully!']);
        }
        return response()->json(['massage'=>'This comment is not yours']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteCommentRequest $request, Comment $comment)
    {
        $user = auth()->user();
        if($comment->checkOwner($user->id)) {
            $comment->delete();
            return response()->json(['massage'=>'Comment deleted successfully!']);
        }
        return response()->json(['massage'=>'This comment is not yours']);
    }
}
