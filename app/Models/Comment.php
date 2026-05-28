<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'post_id',
        'user_id',
        'content',
    ];

    public function post()//コメントがどの投稿についたコメントなのかを保存するためのリレーション
    {
        return $this->belongsTo(Post::class);
    }

    public function user()//コメントがどのユーザーが書いたコメントなのかを保存するためのリレーション
    {
        return $this->belongsTo(User::class);
    }
}
