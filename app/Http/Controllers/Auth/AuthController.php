<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password; // ← ★強固なパスワードルールのための部品

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // 1. 荷物検査（名前は30文字上限、パスワードは強固なルールを適用）
        $request->validate([
            'name' => 'required|string|max:30',
            'email' => 'required|string|email|max:255|unique:users',
            // パスワードには英語の小文字、大文字、数字、記号を最低一つ以上入れないとダメ
            'password' => ['required', 'string', Password::min(8)->mixedCase()->numbers()->symbols()],
        ]);

        // 2. データベースへ登録（パスワードはそのまま入れず暗号化する）
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // 3. IDカード（トークン）を発行する
        $token = $user->createToken('auth_token')->plainTextToken;

        // 4. React店舗へ「成功したよ」という返事とデータを返す
        return response()->json([
            'message' => 'ユーザー登録が完了しました',
            'user' => $user,
            'token' => $token
        ], 201);
    }
}
