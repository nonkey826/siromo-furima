<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
{
    $user = $request->user();

    // プロフィール作成 or 更新
    $user->profile()->updateOrCreate(
        ['user_id' => $user->id],
        ['nickname' => $request->nickname]
    );

    // 住所作成 or 更新
    $user->address()->updateOrCreate(
        ['user_id' => $user->id],
        [
            'zipcode' => $request->postal_code,
            'address' => $request->address,
            'building' => $request->building,
        ]
    );

    // ✅ プロフィール完了フラグ
    $user->update([
        'profile_completed' => true,
    ]);

    // ✅ 設定完了後は商品一覧へ
    return Redirect::route('items.index')
        ->with('status', 'profile-updated');
}


    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
