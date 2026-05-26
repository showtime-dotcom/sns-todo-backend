<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    // 💡 これを追加：自分がブックマークした投稿一覧を取得する処理
    public function index()
    {
        // エディタの勘違いを正すためのメモ
        /** @var \App\Models\User $user */
        $user = auth()->user();

        // 自分がブックマークした投稿を新しい順に取得
        // ※もしUser.phpでのリレーション名が 'bookmarks' ではなく 'bookmarkedPosts' などの場合は、
        // ご自身の環境に合わせて 'bookmarks()' の部分を変更してください。
        $bookmarkedPosts = $user->bookmarks()->with('user')->latest()->get();

        return response()->json($bookmarkedPosts);
    }

    // 既存のブックマーク追加・解除処理（この部分はそのまま残す）
    public function toggle($postId)
    {
        $post = Post::findOrFail($postId);
        // ... (現在書かれているコード) ...
    }
}
