<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyPageController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $profile = $user->profile;
        $page = $request->query('page', 'buy');

        if ($page === 'sell') {
            // 出品した商品（Item）
            $items = $user->items()
                ->latest()
                ->get();

        } elseif ($page === 'favorite') {
            // お気に入りした商品（Item）
            $items = $user->favorites()
                ->with('item')
                ->get()
                ->pluck('item')
                ->filter();

        } else {
            // 購入した商品（Item）
            $items = $user->purchases()
                ->with('item')
                ->get()
                ->pluck('item')
                ->filter();
        }

        return view('mypage.index', compact(
            'user',
            'profile',
            'items',
            'page'
        ));
    }
}
