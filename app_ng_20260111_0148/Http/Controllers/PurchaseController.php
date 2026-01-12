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

    // 決済画面表示
    public function input(Item $item)
    {
        $user = Auth::user();

        if ($item->is_sold || $item->user_id === $user->id) {
            return redirect()->route('items.show', $item);
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        $intent = PaymentIntent::create([
            'amount' => $item->price,
            'currency' => 'jpy',
            'metadata' => [
                'item_id'  => $item->id,
                'buyer_id' => $user->id,
            ],
        ]);

        return view('purchase.input', [
            'item'         => $item,
            'clientSecret' => $intent->client_secret,
            'stripeKey'    => config('services.stripe.key'),
        ]);
    }

    // 決済完了後
    public function complete(Item $item)
    {
        if ($item->is_sold) {
            return redirect()->route('mypage.index', ['page' => 'buy']);
        }

        $item->update([
            'is_sold'  => true,
            'buyer_id' => Auth::id(),
        ]);

        return redirect()->route('mypage.index', ['page' => 'buy']);
    }
}
