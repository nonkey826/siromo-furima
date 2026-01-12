<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    /**
     * いいね
     */
    public function store(Item $item)
    {
        $user = auth()->user();

        // 自分の商品はいいね不可（保険）
        if ($item->user_id === $user->id) {
            return back();
        }

        // すでにいいねしていなければ登録
        if (!$user->likedItems()->where('item_id', $item->id)->exists()) {
            $user->likedItems()->attach($item->id);
        }

        return back();
    }

    /**
     * いいね解除
     */
    public function destroy(Item $item)
    {
        $user = auth()->user();

        $user->likedItems()->detach($item->id);

        return back();
    }

        /**
     * マイリスト一覧
     */
    public function index()
    {
        $items = auth()->user()
            ->likedItems()
            ->withCount('comments')
            ->latest()
            ->get();

        return view('likes.index', compact('items'));
    }

}
