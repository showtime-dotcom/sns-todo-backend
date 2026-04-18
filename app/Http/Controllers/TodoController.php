<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    // ① Todoの一覧を渡す（取得）
    public function index()
    {
        $todos = Todo::where('user_id', 1)->orderBy('created_at', 'desc')->get();
        return response()->json($todos);
    }

    // ② 新しいTodoを保存する（作成）
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $todo = Todo::create([
            'user_id' => 1,
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
        $todo = Todo::find($id);
        if (!$todo) {
            return response()->json(['message' => '見つかりません'], 404);
        }
        return response()->json($todo);
    }

    // ④ 既存のTodoを更新する（編集）
    public function update(Request $request, $id)
    {
        $todo = Todo::find($id);
        if (!$todo) {
            return response()->json(['message' => '見つかりません'], 404);
        }

        // 送られてきたデータがあれば上書きする
        $todo->title = $request->title ?? $todo->title;
        $todo->description = $request->description ?? $todo->description;
        $todo->category = $request->category ?? $todo->category;
        $todo->priority = $request->priority ?? $todo->priority;
        $todo->due_date = $request->due_date ?? $todo->due_date;
        $todo->status = $request->status ?? $todo->status;

        // 完了日時（completed_at）の自動記録・解除
        if ($request->status === 'completed') {
            $todo->completed_at = now();
        } else {
            $todo->completed_at = null;
        }

        $todo->save();

        // 更新が終わった最新のデータをReactに返す
        return response()->json($todo);
    }

    // ⑤ Todoを削除する
    public function destroy($id)
    {
        $todo = Todo::find($id);
        if ($todo) {
            $todo->delete();
        }

        // 削除が終わったら「OK」という合図だけを返す（画面移動はReactがやります）
        return response()->json(['message' => '削除完了'], 200);
    }
}
