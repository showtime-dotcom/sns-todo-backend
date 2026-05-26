<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    // 💡 これを追加：自分がいいねした投稿一覧を取得する処理
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        // 自分がいいねした投稿を新しい順に取得
        $likedPosts = $user->likedPosts()->with('user')->latest()->get();

        return response()->json($likedPosts);
    }

    // 既存のいいね追加・解除処理（この部分はそのまま残す）
    public function toggle($postId)
    {
        $post = Post::findOrFail($postId);
        // ... (現在書かれているコード) ...
    }
}
