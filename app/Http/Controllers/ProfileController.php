<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;
use App\Models\Address;

class ProfileController extends Controller
{
    /**
     * プロフィール編集画面
     */
    public function edit()
    {
        $user = Auth::user();

        return view('profile.edit', [
            'profile' => $user->profile,
            'address' => $user->address,
        ]);
    }

    /**
     * プロフィール更新処理
     */
    public function update(Request $request)
    {
        $request->validate([
            'nickname'    => 'nullable|max:255',
            'postal_code' => 'nullable|max:20',
            'address'     => 'nullable|max:255',
            'building'    => 'nullable|max:255',
        ]);

        $user = Auth::user();

        // プロフィール保存（なければ作成）
        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'nickname' => $request->nickname,
            ]
        );

        // 住所保存（なければ作成）
        $user->address()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'postal_code' => $request->postal_code,
                'address'     => $request->address,
                'building'    => $request->building,
            ]
        );

        return redirect()->route('mypage.index');
    }
}
