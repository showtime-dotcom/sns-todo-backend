<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash; // 💡 追加：パスワード比較用

class AuthController extends Controller
{
    // ログイン
    public function login(Request $request)
    {
        // ① 入力チェック
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // ② DBから直接ユーザーを探す（これでエディタがUserモデルだと認識し、赤波線が消えます）
        $user = User::where('email', $request->email)->first();

        // ③ ユーザーが存在しない、またはパスワードが一致しない場合（Auth::attemptの代わり）
        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'メールアドレスまたはパスワードが違います'
            ], 401);
        }

        // ④ トークン発行（赤波線は出なくなります）
        // 💡 任意：ここで古いトークンを消しておくと、ログインのたびにゴミデータが溜まるのを防げます
        $user->tokens()->delete();

        $token = $user->createToken('auth_token')->plainTextToken;

        // ⑤ レスポンスを返す
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
