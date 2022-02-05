<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FollowController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum']);
    }
    
    public function following(Request $request){ 
        return response([
            "status" => "Success",
            "data" => $request->user()->load('following')

        ], 200);
    }
    
    public function followers(Request $request){
        return response([
            "status" => "Success",
            "data" => $request->user()->load('followers')

        ], 200);
    }

    public function peopleFollowing(Request $request, $id){
        $user = User::where('id', $id)->with('following')->first();
        if(!$user){
            return response([
                "status" => "Failed",
                "data" => new \stdClass
            ], 404);
        }
        return response([
            "status" => "Success",
            "data" => $user
        ], 200);
    }

    public function peopleFollowers(Request $request, $id){
        $user = User::where('id', $id)->with('followers')->first();
        if(!$user){
            return response([
                "status" => "Failed",
                "data" => new \stdClass
            ], 404);
        }
        return response([
            "status" => "Success",
            "data" => $user
        ], 200);
    }

    public function follow(Request $request, $id){
        if($id == $request->user()->id){
            return response([
                "status" => "Error",
                "message" => "Cannot Follow Yourself"
            ], 400);
        }
        $follow = Follow::create([
            'following'=>$request->user()->id,
            'followers'=> $id
        ]);
        
        return response([
            "status" => "success",
            "data" => $follow
        ], 201);
    }

    public function unfollow(Request $request, $id){
        $data = DB::table('follows')->where('following', $request->user()->id)
                            ->where('followers', $id)
                            ->delete();

        return response([
            "status" => "success",
            "data" => $data
        ], 201);
    }

    
}
