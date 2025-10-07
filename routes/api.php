<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/auth/login', [\App\Http\Controllers\AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/auth/logout', [\App\Http\Controllers\AuthController::class, 'logout']);

Route::get('/posts', [\App\Http\Controllers\PostController::class, 'index']);
Route::get('/posts/{post}', [\App\Http\Controllers\PostController::class, 'show']);

Route::get('/comments', [\App\Http\Controllers\CommentController::class, 'index']);
Route::post('/comments', [\App\Http\Controllers\CommentController::class, 'store']);

Route::middleware(['auth:sanctum','admin'])->group(function () {
    Route::post('/admin/activate-post-or-comment', [\App\Http\Controllers\Admin\ActivatePostOrCommentController::class, 'update']);
    Route::apiResource('users', \App\Http\Controllers\UserController::class)->only(['index','show','store','update','destroy']);
});
