<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\SubCommentController;
use App\Http\Controllers\CommentLikeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

//posts guests
Route::get('/posts/guests', [PostController::class, 'indexGuests']);
Route::post('/posts/guests', [PostController::class, 'storeGuests']);
Route::delete('/posts/guests/{post}', [PostController::class, 'deleteGuests']);

//post
Route::get('/posts', [PostController::class, 'index']);
Route::post('/posts', [PostController::class, 'store']);
Route::get('/posts/{id}', [PostController::class, 'specific']);
Route::delete('/posts/{post}', [PostController::class, 'destroy']);
Route::put('/posts/{post}', [PostController::class, 'update']);


//like
Route::get('/likes/{post}', [LikeController::class, 'show']);
Route::post('/likes/{post}', [LikeController::class, 'store']);
Route::delete('/likes/{post}', [LikeController::class, 'destroy']);

//comment like
Route::get('/likes/comment/{comment}', [CommentLikeController::class, 'show']);
Route::post('/likes/comment/{comment}', [CommentLikeController::class, 'store']);
Route::delete('/likes/comment/{comment}', [CommentLikeController::class, 'destroy']);

//comment
Route::get('/comments/{post}', [CommentController::class, 'show']);
Route::post('/comments/{post}', [CommentController::class, 'store']);

//subcomment
Route::get('{comment}', [SubCommentController::class, 'show']);
Route::post('/subcomments/{comment}', [SubCommentController::class, 'store']);

//follows
Route::get('/following', [FollowController::class, 'following']);
Route::get('/followers', [FollowController::class, 'followers']);
Route::get('/following/{id}', [FollowController::class, 'peopleFollowing']);
Route::get('/followers/{id}', [FollowController::class, 'peopleFollowers']);
Route::post('/follows/{id}', [FollowController::class, 'follow']);
Route::delete('/follows/{id}', [FollowController::class, 'unfollow']);

//profile
Route::get('/profile', [UserController::class, 'index']);
Route::get('/profile/{id}', [UserController::class, 'people']);





