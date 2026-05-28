<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();//コメント1件ごとの番号

            $table->foreignId('post_id')//コメントがどの投稿についたコメントなのかを保存
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('user_id')//コメントがどのユーザーが書いたコメントなのかを保存
                ->constrained()
                ->cascadeOnDelete();//ユーザーが削除されたときに、そのユーザーのコメントも削除されるようにする

            $table->text('content');//コメントの内容

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
