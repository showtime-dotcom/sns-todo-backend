<?php

use App\Http\Controllers\TodoController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Api\AuthController as ApiAuthController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\UserController;   // 検索機能用（masterから来たもの）
use App\Http\Controllers\FollowController; // フォロー機能用（今回追加したもの）

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// 新規登録
Route::post('/register', [AuthController::class, 'register']);

// ログイン
Route::post('/login', [ApiAuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    // ログイン中のユーザー情報
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/me', [ApiAuthController::class, 'me']);
    Route::post('/logout', [ApiAuthController::class, 'logout']);

    // ToDo関連
    Route::get('/todos', [TodoController::class, 'index']);
    Route::get('/todos/{id}', [TodoController::class, 'show']);
    Route::post('/todos', [TodoController::class, 'store']);
    Route::put('/todos/{id}', [TodoController::class, 'update']);
    Route::delete('/todos/completed', [TodoController::class, 'destroyCompleted']);
    Route::delete('/todos/{id}', [TodoController::class, 'destroy']);

    // 投稿関連
    Route::get('/posts', [PostController::class, 'index']);
    Route::post('/posts', [PostController::class, 'store']);
    Route::put('/posts/{post}', [PostController::class, 'update']);
    Route::delete('/posts/{post}', [PostController::class, 'destroy']);

    // プロフィール画面用
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::put('/profile', [ProfileController::class, 'update']);

    // 検索機能
    Route::get('/users', [UserController::class, 'index']);

    // フォロー機能
    Route::post('/users/{id}/follow', [FollowController::class, 'toggle']);

    // いいね・ブックマーク関連
    Route::post('/posts/{post}/like', [LikeController::class, 'toggle']);
    Route::get('/bookmarks', [BookmarkController::class, 'index']);
    Route::post('/posts/{post}/bookmark', [BookmarkController::class, 'toggle']);
});
