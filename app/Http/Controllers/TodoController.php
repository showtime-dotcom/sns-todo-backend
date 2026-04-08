<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo; //追加

class TodoController extends Controller
{
    // タスク一覧を表示するメソッド
    public function index()
    {
        // データベースから全てのTodoを取得する
        $todos = Todo::all();

        // 画面に $todos という変数を渡す
        return view('todos.index', compact('todos'));
    }

    // 登録画面を表示するメソッド
    public function create()
    {
        return view('todos.create');
    }

    // ↓ここはエラー回避のためにダミーで無理やりデータを作るためのメソッド
    public function store(Request $request)
    {
        // 1. バリデーション（もし失敗したら、ここで自動的に前の画面に戻されます）
        // $validated には「チェックを通過した正しいデータだけ」が入ります
        $validated = $request->validate([
            'title' => 'required|max:20',
            'description' => 'nullable|max:200',
            'due_date' => 'nullable|date|after_or_equal:today',
        ]);

        // 2. 「フォームのデータ」と「固定のデータ」を合体させる
        // $request->input('due_date') が空なら、今日の日付を入れる（?? は「または」の意味）
        $data = [
            'title'       => $validated['title'],
            'description' => $validated['description'], // 入力がなければnullが入る
            'due_date'    => $validated['due_date'] ?? now()->format('Y/m/d'), // ←ここ重要！

            // 自動補完するデータ
            'user_id'     => 1,
            'priority'    => '普通',
            'status'      => '未着手',
            'category'    => '一般',
        ];

        // 3. データを保存
        // ※注意：Todo.php（モデル）の $fillable にこれらのカラム名が書いてある必要があります！
        \App\Models\Todo::create($data);

        // 4. 一覧画面に戻る
        return redirect()->route('todos.index');
    }
    //↑ここはエラー回避のためにダミーで無理やりデータを作るためのメソッド（正式に会員登録できるようになったらコメントアウトすること）

    // // データを保存するメソッド
    // public function store(Request $request)
    // {
    //     // 1. フォームから送られてきたデータを全部受け取って、Todo作成！
    //     // （$fillableに書いた項目だけが保存されます）
    //     Todo::create($request->all());

    //     // 2. 一覧画面に戻る（リダイレクト）
    //     return redirect()->route('todos.index');
    // }

    // Todoの中身を表示するメソッド
    public function show($id)
    {
        // IDを使ってデータベースから検索
        $todo = \App\Models\Todo::find($id);

        // 詳細画面（show.blade.php）を表示
        return view('todos.show', compact('todo'));
    }

    // 編集画面を表示するメソッド
    public function edit($id)
    {
        // 編集するタスクを取得
        $todo = \App\Models\Todo::find($id);

        // 編集画面（edit.blade.php）を表示
        // ※このファイルは次回作ります！
        return view('todos.edit', compact('todo'));
    }

    // 更新処理を実行するメソッド
    public function update(Request $request, $id)
    {
        // 1. IDでタスクを探す
        $todo = \App\Models\Todo::find($id);

        // 2. フォームから送られてきたデータで上書きする
        $todo->title = $request->title;          // タイトル
        $todo->description = $request->description; // 内容
        $todo->due_date = $request->due_date;    //期限
        $todo->status = $request->status;        // 状態（未着手など）

        // ※期限（due_date）も更新したい場合はここに追加しますが、
        // 今の編集画面にはまだ入力欄がないので一旦保留！

        // 3. データベースに保存（UPDATE文が走る）
        $todo->save();

        // 4. 詳細画面に戻って「変更されたかな？」と確認させる
        return redirect()->route('todos.show', $todo->id);
    }

    // 削除処理を実行するメソッド
    public function destroy($id)
    {
        // 1. 削除するタスクを探す
        $todo = \App\Models\Todo::find($id);

        // 2. 削除する（物理的に消えます！）
        $todo->delete();

        // 3. 一覧画面に戻る
        return redirect()->route('todos.index');
    }
}
