<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', [AuthController::class,'login']);
    Route::post('logout', [AuthController::class,'logout'])->middleware('check_auth');
    Route::post('register', [AuthController::class,'register']);
    Route::post('refresh', [AuthController::class,'refresh']);
    Route::post('me', [AuthController::class,'me'])->middleware('check_auth');

});


Route::resource('posts', PostController::class)->except(['create', 'edit']);
Route::post('/post/{post}/like',[PostController::class,'like']);
Route::post('/post/{post}/dislike',[PostController::class,'dislike']);
Route::post('/post/{post}/comment',[PostController::class,'submitComment']);


Route::resource('comments', CommentController::class)->only(['update', 'destroy']);


