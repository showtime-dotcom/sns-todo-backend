<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('todos', function (Blueprint $table) {
            $table->id(); // 整理番号

            // 誰のTodoかを記録する（今は仮ですが後で必須になります）
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Todoの中身
            $table->string('title'); // タイトル（必須）
            $table->text('description')->nullable(); // 詳細（空でもOK）
            $table->string('category')->nullable(); // カテゴリ（空でもOK）
            $table->string('status')->default('todo'); // 状態（初期値はtodo）
            $table->integer('priority')->nullable(); // 優先度（数字）
            $table->dateTime('due_date')->nullable(); // 期限
            $table->dateTime('completed_at')->nullable(); // 完了した日時

            $table->timestamps(); // 作成日時・更新日時（自動）
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
