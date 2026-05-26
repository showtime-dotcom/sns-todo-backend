<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    // 💡 追加：プロフィール情報（＋フォロー・フォロワー数）を取得する処理
    public function show(Request $request)
    {
        $user = $request->user();

        // Laravelの便利機能！データベースから数を数えて自動で合体させてくれる
        $user->loadCount(['followings', 'followers']);

        return response()->json($user);
    }

    // プロフィールを更新する処理
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'bio'  => 'nullable|string|max:1000',
        ]);

        $user = $request->user();
        $user->name = $request->name;
        $user->bio = $request->bio;
        $user->save();

        return response()->json($user);
    }
}
