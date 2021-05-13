<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum']);
    }

    public function show(Post $post){
        $data = Like::select('id', 'post_id', 'user_id')->where('post_id', $post->id)->with('details')->get();
        return response([
        "status" => "Success",
        "data" => $data
        ], 201);
    }

    public function store(Post $post, Request $request){
        if($post->likedBy($request->user())){
            return response([
                "status" => "Error",
                "message" => "Already Liked the Post"
            ], 400); 
        }

        $data = $post->likes()->create([
            'user_id'=>$request->user()->id,
        ]);

        return response([
        "status" => "Success",
        "data" => $data
        ], 201);
    }

    public function destroy(Post $post, Request $request){
        if(!$post->likedBy($request->user())){
            return response([
                "status" => "Error",
                "message" => "Not Like the Post"
            ], 400); 
        }
        $data = $request->user()->likes()->where('post_id', $post->id)->delete();

        return response([
            "status" => "Success",
            "data" => $data
        ]);
    }
}
