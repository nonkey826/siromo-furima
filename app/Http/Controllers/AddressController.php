<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        $address = $user->address()->first();

        return view('address.edit', compact('address'));
    }

    public function update(Request $request)
{
    $user = Auth::user();

    $data = $request->validate([
        'zipcode'  => 'required|string',
        'address'  => 'required|string',
        'building' => 'nullable|string',
        'item_id'  => 'nullable|integer',
    ]);

    $itemId = $data['item_id'] ?? null;
    unset($data['item_id']);

    $address = $user->address()->first();

    if ($address) {
        $address->update($data);
    } else {
        $user->address()->create($data);
    }

    // ✅ 購入フローから来た場合
    if ($itemId) {
        return redirect()->route('purchase.input', $itemId);
    }

    // ✅ 通常ルート
    return redirect()->route('mypage.index');
}


}
