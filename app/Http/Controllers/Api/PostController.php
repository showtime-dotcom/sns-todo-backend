<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    // 投稿一覧
public function index()
{
    $userId = auth()->id();

    return Post::with('user:id,name')
        ->withCount(['likedByUsers as likes_count'])
        ->withExists([
            'likedByUsers as is_liked' => function ($query) use ($userId) {
                $query->where('user_id', $userId);
            },
            'bookmarkedByUsers as is_bookmarked' => function ($query) use ($userId) {
                $query->where('user_id', $userId);
            },
        ])
        ->latest()
        ->get();
}

    // 投稿作成
    public function store(Request $request)
    {
        $validated = $request->validate([
            'contents' => ['required', 'string', 'max:1000'],
        ]);

        $post = Post::create([
            'user_id' => auth()->id(),
            'contents' => $validated['contents'],
        ]);

        return $post->load('user:id,name');
    }

    // 更新
    public function update(Request $request, Post $post)
    {
        if ($post->user_id !== auth()->id()) {
            return response()->json(['message' => '権限なし'], 403);
        }

        $validated = $request->validate([
            'contents' => ['required', 'string'],
        ]);

        $post->update($validated);

        return $post->load('user:id,name');
    }

    // 削除
    public function destroy(Post $post)
    {
        if ($post->user_id !== auth()->id()) {
            return response()->json(['message' => '権限なし'], 403);
        }

        $post->delete();

        return response()->json(['message' => '削除完了']);
    }
}
