<?php

namespace App\Http\Controllers;

use App\Models\Post;

class LikeController extends Controller
{
    // いいねの追加・解除を自動判定する処理
    public function toggle($postId)
    {
        $post = Post::findOrFail($postId);

        // 💡 エディタの勘違いを正すためのメモを追加
        /** @var \App\Models\User $user */
        $user = auth()->user();

        // toggle()がよしなに判定して追加・削除を行ってくれる
        $result = $user->likedPosts()->toggle($post->id);

        $isLiked = count($result['attached']) > 0;

        return response()->json([
            'message' => $isLiked ? 'いいねしました' : 'いいねを解除しました',
            'liked' => $isLiked
        ]);
    }
}
