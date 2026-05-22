<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'user_id',
        'contents',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // この投稿にいいねしたユーザーを取得する繋がり
    public function likedByUsers()
    {
        return $this->belongsToMany(User::class, 'likes')->withTimestamps();
    }

    // この投稿をブックマークしたユーザーを取得する繋がり
    public function bookmarkedByUsers()
    {
        return $this->belongsToMany(User::class, 'bookmarks')->withTimestamps();
    }
}
