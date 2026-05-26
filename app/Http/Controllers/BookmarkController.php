<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    // 自分がブックマークした投稿一覧を取得する処理（ここは触らなくてOK）
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        $bookmarkedPosts = $user->bookmarks()->with('user')->latest()->get();
        return response()->json($bookmarkedPosts);
    }

    // 💡 ここを完全に書き換えます！
    public function toggle($postId)
    {
        $post = Post::findOrFail($postId);
        /** @var \App\Models\User $user */
        $user = auth()->user();

        // toggle() メソッドを使うと、既に存在していれば削除（解除）、なければ挿入（保存）を自動で行ってくれます
        // $result['attached'] にデータが入っていれば「新しく保存した」という意味になります
        $result = $user->bookmarks()->toggle($post->id);

        $isBookmarked = count($result['attached']) > 0;

        // React側に「現在の状態」をハッキリと返す
        return response()->json([
            'status' => 'success',
            'bookmarked' => $isBookmarked
        ]);
    }
}
