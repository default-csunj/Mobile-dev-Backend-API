<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FollowController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum']);
    }
    
    public function following(Request $request){
        $userId = [];
        if($request->user()){
            $following = $request->user()->following()->get();
            for( $i = 0; $i < $following->count(); $i++){
                $userId[] = $following[$i]->followers;
            }
        }
        $users = User::latest()->whereIn('id', $userId)->get();
        
        return response([
            "status" => "Success",
            "data" => $users

        ], 200);
    }
    
    public function followers(Request $request){
        $userId = [];
        if($request->user()){
            $followers = $request->user()->followers()->get();
            for( $i = 0; $i < $followers->count(); $i++){
                $userId[] = $followers[$i]->following;
            }
        }
        $users = User::latest()->whereIn('id', $userId)->get();
        return response([
            "status" => "Success",
            "data" => $users

        ], 200);
    }

    public function peopleFollowing(Request $request, $id){
        $userId = [];
        $user = User::find($id);
        $following = $user->following()->get();
        for( $i = 0; $i < $following->count(); $i++){
            $userId[] = $following[$i]->followers;
        }
        $users = User::latest()->whereIn('id', $userId)->get();
        return response([
            "status" => "Success",
            "data" => $users

        ], 200);
    }

    public function peopleFollowers(Request $request, $id){
        $userId = [];
        $user = User::find($id);
        $followers = $user->followers()->get();
        for( $i = 0; $i < $followers->count(); $i++){
            $userId[] = $followers[$i]->following;
        }
        $users = User::latest()->whereIn('id', $userId)->get();
        return response([
            "status" => "Success",
            "data" => $users
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
