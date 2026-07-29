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
        Schema::table('users', function (Blueprint $table) {
            // 💡 ユーザーの画像ファイル名を保存するカラムを追加
            // nullable() をつけることで「画像が登録されていない状態」を許可します
            $table->string('avatar')->nullable()->after('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // 💡 ロールバック（元に戻す）時のために削除処理を書く
            $table->dropColumn('avatar');
        });
    }
};
