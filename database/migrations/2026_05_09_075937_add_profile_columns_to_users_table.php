<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // 自己紹介文（長文も入るようにtext型、空でもOKに設定）
            $table->text('bio')->nullable()->after('name');
            // アイコン画像の保存場所（文字情報として保存、空でもOK）
            $table->string('icon_path')->nullable()->after('bio');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // 元に戻すときは、追加した2つの枠を消す
            $table->dropColumn(['bio', 'icon_path']);
        });
    }
};
