<?php

use App\Http\Controllers\TodoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\Api\TodoController;
use App\Http\Controllers\Auth\AuthController;

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

// スプレッドシートの定義通り: GET /api/todos
Route::get('/todos', [TodoController::class, 'index']);

Route::get('/todos/{id}', [TodoController::class, 'show']);

Route::post('/todos', [TodoController::class, 'store']);

Route::put('/todos/{id}', [TodoController::class, 'update']);

Route::delete('/todos/completed', [TodoController::class, 'destroyCompleted']);

Route::delete('/todos/{id}', [TodoController::class, 'destroy']);

Route::post('/register', [AuthController::class, 'register']);

Route::get('/todos', [TodoController::class, 'index']); // 一覧ちょうだい、の道

Route::post('/todos', [TodoController::class, 'store']); // 新しく保存して、の道
