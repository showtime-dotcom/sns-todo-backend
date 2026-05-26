<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // 自分以外のユーザーを取得する（ここで自分を除外してくれています）
        $query = User::where('id', '!=', auth()->id());

        // キーワード検索がある場合の絞り込み
        if ($request->filled('keyword')) {
            $query->where('name', 'LIKE', '%' . $request->keyword . '%');
        }

        $users = $query->get();

        // 💡 追加：現在のログインユーザーが「フォローしている人たちのID一覧」をまとめて取得する
        $followingIds = auth()->user()->followings()->pluck('users.id')->toArray();

        // 💡 追加：各ユーザーのデータに「is_following（フォロー中かどうかのTrue/False）」をくっつける
        $users->transform(function ($user) use ($followingIds) {
            $user->is_following = in_array($user->id, $followingIds);
            return $user;
        });

        return response()->json($users);
    }
}
