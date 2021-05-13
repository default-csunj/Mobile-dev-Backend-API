<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class SubCommentController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth:sanctum']);
    }

    public function show($id, Request $request){
        $data = Comment::find($id)->with('subComments')->first();
        
        return response([
            "status" => "success",
            "data" => $data
        ], 201);
    }

    public function store(Comment $comment, Request $request){
        $this->validate($request, [
            'sub_comment' => 'required'
        ]);

        $data = $comment->subComments()->create([
            'user_id'=>$request->user()->id,
            'sub_comment'=>$request->sub_comment
        ]);

        return response([
            'status' => "success",
            'data' => $data
        ], 201);
    }
}
