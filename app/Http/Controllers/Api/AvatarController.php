<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class AvatarController extends Controller
{
    public function update(Request $request)
    {
        // ① バリデーション（ピクセル制限も完備した強固な壁）
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048|dimensions:max_width=2000,max_height=2000',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // ② 古い画像があれば削除
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        // ③ 送られてきた画像データを一時的に受け取る
        $file = $request->file('avatar');

        // 💡 ここからが「作戦A」の画像処理
        // XAMPPに標準搭載されている「GD」という機能を使って画像を読み込む
        $manager = new ImageManager(new Driver());
        $image = $manager->read($file->path());

        // 400x400ピクセルの正方形に綺麗に切り抜く（SNSアイコンに最適化！）
        // ※「新しい画像を作り直す」処理になるため、元の位置情報（EXIF）はこの時点で完全に消滅します
        $image->cover(400, 400);

        // 重複しないランダムなファイル名を作成（例: avatars/64b5... .jpg）
        $filename = 'avatars/' . uniqid() . '.jpg';

        // JPEG形式（画質80%）に変換して、ストレージに保存
        Storage::disk('public')->put($filename, (string) $image->toJpeg(80));

        // ④ データベースに新しいファイル名を記録
        $user->avatar = $filename;
        $user->save();

        return response()->json([
            'message' => 'プロフィール画像を安全に更新しました。',
            'user' => $user,
        ]);
    }
}
