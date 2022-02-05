<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum']);
    }

    public function show(Post $post){
        $data = Comment::select('id', 'post_id', 'user_id', 'comment')->where('post_id', $post->id)->withCount('likes')->withCount('subComments')->with(['details','subComments.user'])->first();
        return response([
            'comments' => $data,
        ], 200);
    }

    public function store(Post $post, Request $request){
        $this->validate($request, [
            'comment' => 'required'
        ]);

        $data = $post->comments()->create([
            'user_id'=>$request->user()->id,
            'comment'=>$request->comment
        ]);

        return response([
            'status' => "success",
            'data' => $data
        ], 201);
    }
}
