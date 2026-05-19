<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // ログイン
    public function login(Request $request)
    {
        // ① 入力チェック(メールとパスワードがちゃんと来てるか確認)
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // ② ログイン試行(DBの users テーブルと照合してログイン判定)
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'メールアドレスまたはパスワードが違います'
            ], 401);
        }

        // ③ ログイン成功 → ユーザー取得(ログイン成功した人の情報を取得)
        $user = Auth::user();

        // ④ トークン発行(「この人ログイン済みです」という証明を作る)
        $token = $user->createToken('auth_token')->plainTextToken;

        // ⑤ レスポンス返す(Reactが受け取ってログイン状態になる)
        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
    }

    // ログアウト
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'ログアウトしました'
        ]);
    }

    // ログイン中ユーザー取得
    public function me(Request $request)
    {
        return response()->json($request->user());
    }
}
