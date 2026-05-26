<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // ユーザーがいいねした投稿を取得する繋がり
    public function likedPosts()
    {
        return $this->belongsToMany(Post::class, 'likes')->withTimestamps();
    }

    // ユーザーがブックマークした投稿を取得する繋がり
    // 💡 これを追加：ユーザーがブックマークした投稿一覧との繋がり
    public function bookmarks()
    {
        // 投稿（Postモデル）と多対多の関係で繋ぐ
        // 中間テーブルの名前が 'bookmarks' の場合は以下で動きます
        return $this->belongsToMany(Post::class, 'bookmarks')->withTimestamps();
    }
    // 自分がフォローしているユーザー達を取得する設定
    public function followings()
    {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'followed_id')->withTimestamps();
    }

    // 自分をフォローしているユーザー達（フォロワー）を取得する設定
    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'followed_id', 'follower_id')->withTimestamps();
    }
}
