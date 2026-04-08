<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('todos', function (Blueprint $table) {
            $table->id();
            // 誰のタスクかを記録する（ユーザーが消えたらタスクも消す設定）
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->string('title');                 // タイトル
            $table->text('description')->nullable(); // 説明（長文OK・空欄OK）
            $table->string('priority');              // 優先度（高・中・低など）
            $table->date('due_date')->nullable();    // 期限（日付のみ・空欄OK）
            $table->string('status');                // ステータス（未着手など）
            $table->string('category')->nullable();  // カテゴリ（空欄OK）
            $table->timestamps();                    // 作成日時・更新日時
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('todos');
    }
};
