<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register',[AuthController::class,'register'])->name('user.register');
Route::post('/login',[AuthController::class,'login'])->name('user.login');
//Route::get('/test',function (){
//    return Response()->json(dd(\App\Models\User::find(1)->photo->src),200);
//});
Route::middleware('auth:sanctum')->group(function (){
    Route::post('/logout',[AuthController::class,'logout'])->name('user.logout');

    //list of comments or likes
    Route::get('/post/comment/{post}',[PostController::class,'showComments'])->name('comment.show');
    Route::get('/post/like/{post}',[PostController::class,'showLikes'])->name('likes.show');
    //commenting
    Route::post('/comment/answer/{comment}',[CommentController::class,'answer'])->name('comment.answer');
    Route::post('/post/comment/{post}',[PostController::class,'comment'])->name('post.comment');
    //likes
    Route::post('/post/like/{post}',[CommentController::class,'like'])->name('post.like');
    Route::post('/comment/like/{comment}',[CommentController::class,'like'])->name('comment.like');
    //user
    Route::get('/user/{user}',[UserController::class,'show'])->name('user.show');
    //user follows
    Route::get('/user/follows/{user}',[UserController::class,'follows'])->name('user.follows');
    //user followers
    Route::get('/user/followers/{user}',[UserController::class,'followers'])->name('user.followers');
    //follow user
    Route::post('/user/follow/{user}',[UserController::class,'follow'])->name('user.follow');
    //suggested follows
    Route::get('/user/suggested/follows/',[UserController::class,'suggestedUser'])->name('user.follow.suggestion');
    //suggested posts
    Route::get('/user/suggested/posts/',[PostController::class,'suggestedPost'])->name('user.post.suggestion');
    //post resource
    Route::apiResource('post', PostController::class);
});
