<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
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

Route::middleware('auth:sanctum')->group(function (){

    Route::post('/logout',[AuthController::class,'logout'])->name('user.logout');
    Route::post('/comment/answer/{comment}',[CommentController::class,'answer'])->name('comment.answer');
    Route::post('/post/comment/{post}',[PostController::class,'comment'])->name('post.comment');
    Route::apiResource('post', PostController::class);
});
