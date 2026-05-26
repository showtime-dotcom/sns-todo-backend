<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    use HasFactory;

    // 保存を許可するカラム
    protected $fillable = [
        'follower_id',
        'followed_id',
    ];
}
