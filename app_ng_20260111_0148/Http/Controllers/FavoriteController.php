<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Item;

class FavoriteController extends Controller
{
    /**
     * お気に入り登録
     */
    public function store(Item $item)
    {
        Auth::user()->favorites()->attach($item->id);

        return back();
    }

    /**
     * お気に入り解除
     */
    public function destroy(Item $item)
    {
        Auth::user()->favorites()->detach($item->id);

        return back();
    }
}
