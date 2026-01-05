<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Stripeは今は使わないが、後工程用に残す
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

class PurchaseController extends Controller
{
    /**
     * ⑥ 商品購入画面（表示専用）
     */
    public function input(Item $item)
    {
        $user = Auth::user();

        return view('purchase.input', [
            'item'    => $item,
            'user'    => $user,
            'address' => $user->address()->first(),
        ]);
    }

    /**
     * ⑦ Stripe Checkout 作成 → 決済画面へ
     * ※ 今はまだ画面から呼ばれない
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

        // Stripe 初期化
        Stripe::setApiKey(config('services.stripe.secret'));

        // Checkout セッション作成
        $session = StripeSession::create([
            'payment_method_types' => ['card'],
            'mode' => 'payment',
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => [
                        'name' => $item->title,
                    ],
                    'unit_amount' => $item->price,
                ],
                'quantity' => 1,
            ]],
            'metadata' => [
                'item_id'    => $item->id,
                'buyer_id'   => $user->id,
                'address_id' => $address->id,
            ],
            'success_url' => route('purchase.complete', $item) . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url'  => route('purchase.input', $item),
        ]);

        return redirect($session->url);
    }

    public function complete(Request $request, Item $item)
{
    $user = Auth::user();

    // 二重購入防止
    if ($item->is_sold) {
        return redirect()->route('items.show', $item);
    }

    // 購入確定
    $item->is_sold  = true;
    $item->buyer_id = $user->id;
    $item->save();

    return view('purchase.complete', [
        'item' => $item,
    ]);
}


}

