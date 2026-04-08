<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// タスク一覧ページ()
Route::get('/todos', [TodoController::class, 'index'])->name('todos.index');

// 登録画面を表示させる()
Route::get('/todos/create', [TodoController::class, 'create'])->name('todos.create');

// 保存処理（POST通信）
Route::post('/todos', [TodoController::class, 'store'])->name('todos.store');

// 詳細画面を表示するルート
Route::get('/todos/{id}', [App\Http\Controllers\TodoController::class, 'show'])->name('todos.show');

// 編集画面を表示するルート
Route::get('/todos/{id}/edit', [App\Http\Controllers\TodoController::class, 'edit'])->name('todos.edit');

// 更新処理をするルート
Route::put('/todos/{id}', [App\Http\Controllers\TodoController::class, 'update'])->name('todos.update');

// 削除処理を実行するルート
Route::delete('/todos/{id}', [App\Http\Controllers\TodoController::class, 'destroy'])->name('todos.destroy');
