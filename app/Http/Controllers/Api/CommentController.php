<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    // コメント投稿
    public function store(Request $request, Post $post)
    {
        $validated = $request->validate([
            'content' => ['required', 'string', 'max:1000'],
        ]);

        $comment = Comment::create([
            'post_id' => $post->id,
            'user_id' => auth()->id(),
            'content' => $validated['content'],
        ]);

        return $comment->load('user:id,name');
    }

    // コメント更新
    public function update(Request $request, Comment $comment)
    {
        if ($comment->user_id !== auth()->id()) {
            return response()->json(['message' => '権限なし'], 403);// 自分のコメント以外は編集できないようにする
        }

        $validated = $request->validate([
            'content' => ['required', 'string', 'max:1000'],
        ]);

        $comment->update($validated);

        return $comment->load('user:id,name');
    }

    // コメント削除
    public function destroy(Comment $comment)
    {
        if ($comment->user_id !== auth()->id()) {
            return response()->json(['message' => '権限なし'], 403);// 自分のコメント以外は削除できないようにする
        }

        $comment->delete();

        return response()->json(['message' => 'コメントを削除しました']);
    }
}
