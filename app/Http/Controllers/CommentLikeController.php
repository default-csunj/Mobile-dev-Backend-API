<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\CommentLike;
use Illuminate\Http\Request;

class CommentLikeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum']);
    }

    public function show(Comment $comment){
        $data = CommentLike::where('comment_id', $comment->id)->with('details')->get();
        return response([
        "status" => "Success",
        "data" => $data
        ], 201);
    }

    public function store(Comment $comment, Request $request){
        if($comment->likedBy($request->user())){
            return response([
                "status" => "Error",
                "message" => "Already Liked the Comment"
            ], 400); 
        }

        $data = $comment->likes()->create([
            'user_id'=>$request->user()->id,
        ]);

        return response([
            "status" => "Success",
            "data" => $data
            ], 201);
    }

    public function destroy(Comment $comment, Request $request){
        if(!$comment->likedBy($request->user())){
            return response([
                "status" => "Error",
                "message" => "Not Like the Comment"
            ], 400); 
        }
        $data = $request->user()->commentLikes()->where('comment_id', $comment->id)->delete();

        return response([
            "status" => "Success",
            "data" => $data
        ]);
    }
}
