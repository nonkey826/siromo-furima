<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MypageController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        /**
         * タブ制御
         * 許可ページ = buy / sell / favorite
         * default = buy
         */
        $page = $request->input('page', 'buy');

        if (! in_array($page, ['buy', 'sell', 'favorite'])) {
            abort(404);
        }

        /**
         * 出品商品（最新順）
         */
        $sellItems = $user->items()
            ->latest()
            ->get();

        /**
         * 購入商品（最新順）
         */
        $buyItems = $user->purchases()
            ->with([
                'item.user',       // 出品者
                'item.comments',   // コメント数後で使えるように
            ])
            ->latest()
            ->get()
            ->pluck('item');

        /**
         * 今後 favorite 実装する時の布石
         */
        $favoriteItems = collect(); // 空データ保持

        return view('mypage.index', compact(
            'user',
            'page',
            'sellItems',
            'buyItems',
            'favoriteItems'
        ));
    }
}

