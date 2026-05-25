<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // ユーザー一覧の取得と、あいまい検索を行う処理
    public function index(Request $request)
    {
        // React側から送られてくる検索ワード（keyword）を受け取る
        $keyword = $request->input('keyword');

        // ベースとなる検索条件：自分自身は一覧から省く（自分をフォローできないようにするため）
        $query = User::where('id', '!=', auth()->id());

        // 検索ワードが入力されている場合のみ、名前で「あいまい検索」を追加する
        if (!empty($keyword)) {
            // %で囲むことで「その文字が含まれていればOK」という条件になる
            $query->where('name', 'LIKE', "%{$keyword}%");
        }

        // データを取得してReact側に返す
        $users = $query->orderBy('id', 'desc')->get();

        return response()->json($users);
    }
}
