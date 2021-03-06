<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Photos;
use App\Models\PostGuest;
use App\Models\User;

use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum'])->except(['index', 'indexGuests', 'storeGuests', 'deleteGuests']);
    }
    
    public function index()
    {
        $posts = Post::latest()->with('user')->withCount('likes')->withCount('comments')->paginate(5);
        return response([
            'status' => 'success',
            'data' => $posts
        ], 200);
    }
    
    public function store(Request $request)
    {
    
        $this->validate($request, [
            'caption' => 'required'
        ]);
        $post = $request->user()->posts()->create($request->only('caption'));

        if($request->file('image')){
            if($request->file('image')->isValid()){
                $newImageName = time() . '-' . $request->user()->username . '.'. $request->image->extension();
                $request->image->move(public_path('images'), $newImageName);
                $photos = Photos::create([
                    'user_id'=>$request->user()->id,
                    'post_id'=>$post->id,
                    'slug'=>$newImageName
                ]);
                return response([
                    'status' => 'success',
                    'data' => [
                        "post" => $post,
                        "photos" => $photos
                    ]
                    ], 201);
            }
        }

        return response([
            'status' => 'success',
            'data' => $post
        ], 201);
    }

    public function specific($id)
    {
        $post = Post::with('user')->withCount('comments')->with('comments')->find($id);
        return response([
            'status' => 'success',
            'data' => $post
        ], 200);
    }

    public function destroy(Post $post, Request $request)
    {
        if($request->user()->id != $post->user->id){
            return response([
                'status' => "Error",
                'message' => "Invalid User"
            ], 400);
        }
        $data = $post->delete();
        return response([
            "status" => "Success",
            "data" => boolval($data)
        ], 201);
    }

    public function update(Post $post ,Request $request)
    {
        $this->validate($request,[
            'caption' => 'required'
        ]);

        if($request->user()->id != $post->user->id){
            return response([
                'status' => "Error",
                'message' => "Invalid User"
            ], 400);
        }
    
        $post->caption = $request->caption; 
        $post->save();
        return response([
            "status" => "Success",
            "data" => $post
        ], 201);
    }

    public function indexGuests()
    {
        $posts = PostGuest::latest()->get();
        return response([
            'status' => 'success',
            'data' => $posts
        ], 200);
    }

    public function storeGuests(Request $request)
    {
    
        $this->validate($request,[
            'name' => 'required|string',
            'likes' => 'required|integer',
            'comments' => 'required|integer',
            'caption' => 'required|string'
        ]);

        try {
            $post = PostGuest::create([
                "name"=> $request->name,
                "likes"=> $request->likes,
                "comments"=> $request->comments,
                "caption"=> $request->caption
            ]);
    
            return response([
                'status' => 'success',
                'data' => $post
            ], 201);
        } catch (\Throwable $th) {
            return response([
                'status' => 'error',
                'data' => $th
            ], 500);
        }
    }

    public function deleteGuests(Request $request, PostGuest $post)
    {

        try {

            $post->delete();

            return response([
                'status' => 'success delete post',
                'data' => new \stdClass
            ]);
        } catch (\Throwable $th) {
            return response([
                'status' => 'error',
                'data' => $th
            ], 500);
        }

    }
}
