<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TodoController;

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
