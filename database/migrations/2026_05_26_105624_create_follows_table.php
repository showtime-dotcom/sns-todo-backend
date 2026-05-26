<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('follows', function (Blueprint $table) {
            $table->id();

            // follower_id: フォロー「する」側のユーザーID
            $table->foreignId('follower_id')->constrained('users')->onDelete('cascade');

            // followed_id: フォロー「される」側のユーザーID
            $table->foreignId('followed_id')->constrained('users')->onDelete('cascade');

            $table->timestamps();

            // 💡 石橋を叩く設定：同じ人を何度も重複してフォローできないようにブロックする
            $table->unique(['follower_id', 'followed_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('follows');
    }
};
