<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // 1. 荷物検査（送られてきたデータに不備がないか石橋を叩く）
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
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
