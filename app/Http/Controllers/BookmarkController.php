<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    // ブックマークの追加・解除を自動判定する処理
    public function toggle($postId)
    {
        $post = Post::findOrFail($postId);

        // 💡 エディタの勘違いを正すためのメモを追加
        /** @var \App\Models\User $user */
        $user = auth()->user();

        // toggle()がよしなに判定して追加・削除を行ってくれる
        $result = $user->bookmarkedPosts()->toggle($post->id);

        // attached（追加された）にデータが入っていれば「保存状態」、入っていなければ「解除状態」
        $isBookmarked = count($result['attached']) > 0;

        return response()->json([
            'message' => $isBookmarked ? 'ブックマークしました' : 'ブックマークを解除しました',
            'bookmarked' => $isBookmarked
        ]);
    }
}
