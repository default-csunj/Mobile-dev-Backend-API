<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Profiler\Profile;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum']);
    }

    public function index(Request $request)
    {
        $id = $request->user()->id;
        $data = User::where('id', $id)->withCount('following')->withCount('followers')->with('posts')->first();

        return response([
            "status" => "success",
            "data" => $data
        ], 200);
        
    }

    public function people($id)
    {
        $data = User::where('id', $id)->withCount('following')->withCount('followers')->with('posts')->first();

        return response([
            "status" => "success",
            "data" => $data
        ], 200);
        
    }

}
