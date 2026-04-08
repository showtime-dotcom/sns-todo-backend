<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;
    // データを書き込んでもいい項目リスト（許可証）
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'priority',
        'due_date',
        'status',
        'category',
    ];
}
