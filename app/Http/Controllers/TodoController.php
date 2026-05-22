<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    // ① Todoの一覧を渡す（取得）
    public function index()
    {
        $todos = Todo::where('user_id', auth()->id())->orderBy('created_at', 'desc')->get();
        return response()->json($todos);
    }

    // ② 新しいTodoを保存する（作成）
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $todo = Todo::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description ?? null,
            'category' => $request->category ?? null,
            'priority' => $request->priority ?? null,
            'due_date' => $request->due_date ?? null,
            'status' => 'todo',
        ]);

        return response()->json($todo, 201);
    }

    // ③ 指定されたTodo1つだけを渡す（詳細取得）
    public function show($id)
    {
        $todo = Todo::where('id', $id)->where('user_id', auth()->id())->first();
        if (!$todo) {
            return response()->json(['message' => '見つかりません'], 404);
        }
        return response()->json($todo);
    }

    // ④ 既存のTodoを更新する（編集）
    public function update(Request $request, $id)
    {
        $todo = Todo::where('id', $id)->where('user_id', auth()->id())->first();
        if (!$todo) {
            return response()->json(['message' => '見つかりません'], 404);
        }

        $todo->title = $request->title ?? $todo->title;
        $todo->description = $request->description ?? $todo->description;
        $todo->category = $request->category ?? $todo->category;
        $todo->priority = $request->priority ?? $todo->priority;
        $todo->due_date = $request->due_date ?? $todo->due_date;
        $todo->status = $request->status ?? $todo->status;

        if ($request->status === 'completed') {
            $todo->completed_at = now();
        } else {
            $todo->completed_at = null;
        }

        $todo->save();
        return response()->json($todo);
    }

    // ⑤ Todoを削除する
    public function destroy($id)
    {
        $todo = Todo::where('id', $id)->where('user_id', auth()->id())->first();
        if ($todo) {
            $todo->delete();
        }
        return response()->json(['message' => '削除完了'], 200);
    }

    // ⑥ 完了済みのToDoを一括削除する
    public function destroyCompleted()
    {
        $deletedCount = Todo::where('user_id', auth()->id())->where('status', 'completed')->delete();
        return response()->json([
            'message' => "完了済みのタスクを {$deletedCount} 件削除しました"
        ]);
    }
}
