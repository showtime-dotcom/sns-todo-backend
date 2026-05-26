<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    // フォロー・フォロー解除を自動判定する処理
    public function toggle($userId)
    {
        // 💡 石橋を叩く設定：自分自身はフォローできないように弾く
        if (auth()->id() == $userId) {
            return response()->json(['message' => '自分自身はフォローできません'], 400);
        }

        // フォロー対象が存在するか確認（存在しなければ自動で404エラーを返す）
        $targetUser = User::findOrFail($userId);

        // エディタの勘違いを正すためのメモ
        /** @var \App\Models\User $user */
        $user = auth()->user();

        // toggle()がよしなに判定して追加・削除を行ってくれる
        $result = $user->followings()->toggle($targetUser->id);

        // attached（追加された）にデータが入っていれば「フォロー状態」、入っていなければ「解除状態」
        $isFollowing = count($result['attached']) > 0;

        return response()->json([
            'message' => $isFollowing ? 'フォローしました' : 'フォローを解除しました',
            'is_following' => $isFollowing
        ]);
    }
}
