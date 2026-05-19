<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    // プロフィールを更新する処理
    public function update(Request $request)
    {
        // 1. 画面から送られてきたデータをチェックする（名前は必須、自己紹介は空でもOK）
        $request->validate([
            'name' => 'required|string|max:255',
            'bio'  => 'nullable|string|max:1000',
        ]);

        // 2. 今ログインしているユーザーを特定する
        $user = $request->user();

        // 3. データベースの情報を上書きして保存する
        $user->name = $request->name;
        $user->bio = $request->bio;
        $user->save();

        // 4. 保存が完了したら、最新のユーザー情報を画面（React）に返す
        return response()->json($user);
    }
}
