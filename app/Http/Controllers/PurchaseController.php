<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    /**
     * 支払い方法入力画面
     */
    public function input(Item $item)
    {
        $user = Auth::user();

        // 自分の商品は買えない
        if ($item->user_id === $user->id) {
            abort(403, '自分の商品は購入できません');
        }

        // 売却済みは購入不可
        if ($item->is_sold) {
            abort(403, 'この商品は売り切れています');
        }

        return view('purchase.input', [
            'item'    => $item,
            'user'    => $user,
            'address' => $user->address()->first(),
        ]);
    }

    /**
     * 購入確認画面
     */
    public function confirm(Request $request, Item $item)
    {
        $user = auth()->user();

        $request->validate([
            'payment_method' => 'required',
        ]);

        return view('purchase.confirm', [
            'item'          => $item,
            'paymentMethod' => $request->payment_method,
            'user'          => $user,
            'address'       => $user->address()->first(),
        ]);
    }

    /**
     * 購入確定処理
     */
    public function store(Request $request, Item $item)
    {
        $user = Auth::user();

        $request->validate([
            'payment_method' => 'required|string',
        ]);

        // 自分の商品購入禁止
        if ($item->user_id === $user->id) {
            abort(403, '自分の商品は購入できません');
        }

        // 売り切れ禁止
        if ($item->is_sold) {
            abort(403, '商品はすでに売れています');
        }

        // 住所存在チェック
        $address = $user->address()->first();

        if (!$address) {
            return redirect()
                ->route('address.edit')
                ->with('error', '配送先住所を登録してください');
        }

        // 購入レコード保存
        Purchase::create([
            'user_id'        => $user->id,
            'item_id'        => $item->id,
            'address_id'     => $address->id,
            'payment_method' => $request->payment_method,
        ]);

        // 商品を売却済みに変更
        $item->update([
            'is_sold' => true,
        ]);

        return redirect()
            ->route('purchase.complete', $item)
            ->with('success', '購入が完了しました');
    }
}

