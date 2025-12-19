<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    /**
     * 住所編集画面
     */
    public function edit()
    {
        $user = Auth::user();
        $address = $user->address()->first();

        return view('address.edit', compact('address'));
    }

    /**
     * 更新処理
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'zipcode'    => 'nullable',
            'prefecture' => 'nullable',
            'city'       => 'nullable',
            'street'     => 'nullable',
        ]);

        $address = $user->address()->first();

        // DB書き込み内容
        $data = [
            'zipcode'    => $validated['zipcode'] ?? null,
            'prefecture' => $validated['prefecture'] ?? null,
            'city'       => $validated['city'] ?? null,
            'street'     => $validated['street'] ?? null,
        ];

        // update or create
        if ($address) {
            $address->update($data);
        } else {
            $user->address()->create($data);
        }

        return redirect()
            ->route('address.edit')
            ->with('success', '住所を更新しました！');
    }
}
