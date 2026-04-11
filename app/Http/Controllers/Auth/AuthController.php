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
        // 1. 荷物検査（カスタムメッセージを完全網羅）
        $request->validate([
            'name' => 'required|string|max:30',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'string', \Illuminate\Validation\Rules\Password::min(8)->mixedCase()->numbers()->symbols()],
        ], [
            // 以下エラーメッセ－ジ関連
            // 名前に関するエラー
            'name.required' => 'お名前の入力は必須です。',
            'name.max' => 'お名前は30文字以内で入力してください。',

            // メールアドレスに関するエラー
            'email.required' => 'メールアドレスの入力は必須です。',
            'email.email' => '正しい形式のメールアドレスを入力してください。',
            'email.unique' => 'このメールアドレスは既に登録されています。',

            // パスワードに関するエラー
            'password.required' => 'パスワードの入力は必須です。',
            'password.min' => 'パスワードは最低8文字以上必要です。',
            'password.mixed' => 'パスワードには大文字と小文字をそれぞれ1文字以上含めてください。',
            'password.numbers' => 'パスワードには数字を1文字以上含めてください。',
            'password.symbols' => 'パスワードには記号（!や@など）を1文字以上含めてください。',
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
