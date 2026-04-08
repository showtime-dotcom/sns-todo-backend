<?php

namespace App\Http\Controllers\Api;

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    // Todo一覧を取得するAPI
    public function index()
    {
        // データベースからすべてのTodoを取得
        $todos = Todo::all();

        // 画面（View）ではなく、データ（JSON）として返す
        return response()->json($todos);
    }

    // ToDo詳細を取得するAPI（1件だけ）
    public function show($id)
    {
        // 1. IDを元にデータベースから探す
        $todo = Todo::find($id);

        // 2. もし見つからなかったら、エラー（404）を返す
        if (!$todo) {
            return response()->json(['message' => 'データが見つかりません'], 404);
        }

        // 3. 見つかったらJSONで返す
        return response()->json($todo);
    }

    // ToDoを新規作成するAPI
    public function store(Request $request)
    {
        // 1. バリデーション
        $validated = $request->validate([
            'title' => 'required|max:20',
            'description' => 'nullable|max:200',
            'due_date' => 'nullable|date',
        ]);

        // 2. データ準備
        $data = [
            'title'       => $validated['title'],
            'description' => $validated['description'],
            'due_date'    => $validated['due_date'] ?? now()->format('Y-m-d'),

            // 自動補完するデータ（ログイン機能ができるまでは仮置き）
            'user_id'     => 1,
            'priority'    => '普通',
            'status'      => '未着手',
            'category'    => '一般',
        ];

        // 3. データベースに保存
        $todo = \App\Models\Todo::create($data);

        // 4. Reactに「完成したデータ」をJSONで報告する
        // ※ 201 は「新しく作成できました！」という成功サイン
        return response()->json($todo, 201);
    }

    // ToDoを更新するAPI
    public function update(Request $request, $id)
    {
        // 1. 倉庫から指定された整理番号（ID）のパーツを探す
        $todo = Todo::find($id);

        // 2. もし見つからなかったら、エラーを返す（石橋を叩く確実な処理）
        if (!$todo) {
            return response()->json(['message' => 'データが見つかりません'], 404);
        }

        // 3. 送られてきた変更指示書（リクエスト）の検品
        // ※ 'sometimes' は「その項目の変更指示があった時だけチェックする」という効率化のルールです
        $validated = $request->validate([
            'title'       => 'sometimes|required|max:20',
            'description' => 'nullable|max:200',
            'due_date'    => 'nullable|date',
            'status'      => 'sometimes|required|string', // 「完了」などのステータス変更用
        ]);

        // 4. パーツを指示通りに加工して保存（上書き）
        $todo->update($validated);

        // 5. 手直しが完了した最新パーツを、ReactにJSONで報告する
        return response()->json($todo);
    }

    // ToDoを1件削除するAPI
    public function destroy($id)
    {
        $todo = Todo::find($id);

        if (!$todo) {
            return response()->json(['message' => 'データが見つかりません'], 404);
        }

        // 倉庫から完全に破棄
        $todo->delete();

        // 削除完了の報告だけを返す（データはもう無いのでメッセージのみ）
        return response()->json(['message' => '削除が完了しました']);
    }

    // 完了済みのToDoを一括削除（大掃除）するAPI
    public function destroyCompleted()
    {
        // statusが「完了」になっているものを全て探して、一気に削除
        $deletedCount = Todo::where('status', '完了')->delete();

        return response()->json([
            'message' => "完了済みのタスクを {$deletedCount} 件削除しました"
        ]);
    }
}
