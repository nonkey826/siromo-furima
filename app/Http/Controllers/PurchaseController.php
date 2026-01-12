<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class PurchaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 購入画面（入力・確認）
     */
    public function input(Item $item)
    {
        $user = Auth::user();

        // 売り切れ or 自分の商品は不可
        if ($item->is_sold || $item->user_id === $user->id) {
            return redirect()
                ->route('items.show', $item)
                ->with('error', 'この商品は購入できません');
        }

        $address = $user->address()->first();

        return view('purchase.input', [
            'item' => $item,
            'address' => $address,
        ]);
    }

    /**
     * Stripe PaymentIntent 作成
     */
    public function store(Request $request, Item $item)
    {
        $user = Auth::user();

        // 二重購入・自己購入防止
        if ($item->is_sold || $item->user_id === $user->id) {
            return redirect()
                ->route('items.show', $item)
                ->with('error', 'この商品は購入できません');
        }

        // 住所必須
        $address = $user->address()->first();
        if (!$address) {
            return redirect()
                ->route('address.edit')
                ->with('error', '配送先住所を登録してください');
        }

        // Stripe 設定
        Stripe::setApiKey(config('services.stripe.secret'));

        // PaymentIntent 作成（JPYは ×100 不要）
        $paymentIntent = PaymentIntent::create([
            'amount' => $item->price,
            'currency' => 'jpy',
            'metadata' => [
                'item_id' => $item->id,
                'buyer_id' => $user->id,
            ],
        ]);

        return view('purchase.confirm', [
            'item' => $item,
            'address' => $address,
            'clientSecret' => $paymentIntent->client_secret,
            'stripeKey' => config('services.stripe.key'),
        ]);
    }

    /**
     * 決済完了（Stripe 成功後）
     */
    public function complete(Item $item)
    {
        // 未購入状態のみ更新（事故防止）
        if (!$item->is_sold) {
            $item->update([
                'is_sold' => true,
                'buyer_id' => Auth::id(),
            ]);
        }

        return view('purchase.complete', [
            'item' => $item,
        ]);
    }
}

