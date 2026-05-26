<?php

use App\Http\Controllers\TodoController;
// register用↓
use App\Http\Controllers\Auth\AuthController;
// login用↓
use App\Http\Controllers\Api\AuthController as ApiAuthController;
// 投稿機能用↓
use App\Http\Controllers\Api\PostController;
// プロフィール画面用
use App\Http\Controllers\ProfileController;
// イイネ機能用
use App\Http\Controllers\LikeController;
// ブックマーク機能用
use App\Http\Controllers\BookmarkController;
// フォロー機能用
use App\Http\Controllers\FollowController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// ==========================
// 認証なしで使えるAPI
// ==========================

// 新規登録
Route::post('/register', [AuthController::class, 'register']);

// ログイン
Route::post('/login', [ApiAuthController::class, 'login']);


// ==========================
// ログイン済みだけ使えるAPI
// ==========================
Route::middleware('auth:sanctum')->group(function () {

    // ログイン中のユーザー情報
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/me', [ApiAuthController::class, 'me']);

    // ログアウト
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
    Route::put('/profile', [ProfileController::class, 'update']);
    // フォロー機能
    Route::post('/users/{id}/follow', [FollowController::class, 'toggle']);

    // いいね・ブックマーク関連
    Route::post('/posts/{post}/like', [LikeController::class, 'toggle']);
    Route::post('/posts/{post}/bookmark', [BookmarkController::class, 'toggle']);
});
