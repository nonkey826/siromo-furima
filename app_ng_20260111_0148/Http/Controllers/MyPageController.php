<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Item;

class MypageController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $page = $request->input('page', 'sell');

        if (! in_array($page, ['sell', 'buy'])) {
            abort(404);
        }

        // 出品した商品
        $sellItems = Item::where('user_id', $user->id)
            ->latest()
            ->get();

        // 購入した商品（buyer_id を見る）
        $buyItems = Item::where('buyer_id', $user->id)
            ->latest()
            ->get();

        $profile = $user->profile;

        return view('mypage.index', compact(
            'page',
            'sellItems',
            'buyItems',
            'profile'
        ));
    }
}
