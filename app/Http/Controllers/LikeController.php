<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    // 自分がいいねした投稿一覧を取得する処理（ここは触らなくてOK）
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        // 自分がいいねした投稿を新しい順に取得
        $likedPosts = $user->likedPosts()->with('user')->latest()->get();

        return response()->json($likedPosts);
    }

    // 💡 ここを完全に書き換えます！
    public function toggle($postId)
    {
        $post = Post::findOrFail($postId);
        /** @var \App\Models\User $user */
        $user = auth()->user();

        // toggle() で中間テーブル『likes』のレコードを自動でON/OFF（追加/削除）します
        $result = $user->likedPosts()->toggle($post->id);

        // $result['attached'] にデータが入っていれば「新しくいいねした（true）」となります
        $isLiked = count($result['attached']) > 0;

        // React側（PostPage.jsx）の「result.liked」という期待通りの形で返事をする
        return response()->json([
            'status' => 'success',
            'liked' => $isLiked
        ]);
    }
}
