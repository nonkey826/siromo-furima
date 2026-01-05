<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    /**
     * 商品一覧（おすすめ / マイリスト）
     */
    public function index(Request $request)
{
    $query = Item::withCount(['comments', 'likedUsers'])
        ->latest();

    // ログイン中は「自分の商品」を除外
    if (Auth::check()) {
        $query->where('user_id', '!=', Auth::id());

        // マイリストタブ
        if ($request->query('tab') === 'like') {
            $query->whereHas('likedUsers', function ($q) {
                $q->where('user_id', Auth::id());
            });
        }
    }

    // 🔍
    if ($request->filled('keyword')) {
        $keyword = $request->keyword;

        $query->where(function ($q) use ($keyword) {
            $q->where('title', 'like', "%{$keyword}%")
              ->orWhere('description', 'like', "%{$keyword}%");
        });
    }

    $items = $query->get();

    return view('items.index', compact('items'));
}

    /**
     * 商品詳細
     */
    public function show(Item $item)
{
    $item->load([
        'comments.user',
        'user',
        'likedUsers', // ★追加
    ]);

    $comments = $item->comments()
        ->latest()
        ->get();

    $address = Auth::check() && Auth::user()->address
        ? Auth::user()->address
        : null;

    return view('items.show', [
        'item'     => $item,
        'address'  => $address,
        'comments' => $comments,
    ]);
}

    /**
     * 出品フォーム
     */
    public function create()
    {
        return view('items.create');
    }

    /**
     * 商品登録
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'price'       => 'required|integer|min:1',
            'image'       => 'required|string',
        ]);

        Item::create([
            'title'       => $request->title,
            'description' => $request->description,
            'price'       => $request->price,
            'image'       => $request->image,
            'category'    => $request->category,
            'status'      => $request->status,
            'brand'       => $request->brand,
            'user_id'     => Auth::id(),
            'is_sold'     => false,
        ]);

        return redirect()
            ->route('items.index')
            ->with('success', '商品を出品しました');
    }

    /**
     * 商品削除
     */
    public function destroy(Item $item)
    {
        if ($item->user_id !== Auth::id()) {
            abort(403, 'この商品は削除できません');
        }

        if ($item->is_sold) {
            abort(403, '購入済み商品は削除できません');
        }

        $item->delete();

        return redirect()
            ->route('items.index')
            ->with('success', '商品を削除しました');
    }

   

}


