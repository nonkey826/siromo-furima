@extends('layouts.app')

@section('title', '商品一覧')

@section('content')

<style>
.page-title {
    width:85%;
    margin:20px auto;
    font-weight:700;
    font-size:22px;
}

.items-grid {
    width:85%;
    margin:30px auto 80px;
    display:grid;
    grid-template-columns:repeat(auto-fill, minmax(260px,1fr));
    gap:30px;
}

.items-box {
    position: relative;
    background:#fff;
    padding:12px;
    border-radius:6px;
    text-decoration:none;
    color:#000;
    transition:.25s;
    box-shadow:0px 0px 2px rgba(0,0,0,0.08);
}

.items-box:hover {
    opacity:.85;
    transform:translateY(-6px);
}

.items-img {
    width:100%;
    height:240px;
    object-fit:cover;
    border-radius:4px;
    margin-bottom:12px;
    background:#ddd;
}

.items-title {
    font-weight:700;
    margin-bottom:4px;
    font-size:18px;
    line-height:1.4;
}

.items-price {
    font-weight:700;
    color:#e60033;
    font-size:16px;
    margin-top:3px;
}

/* Sold バッジ */
.sold-badge {
    position:absolute;
    top:14px;
    left:14px;
    background:rgba(0,0,0,0.75);
    color:#fff;
    font-size:14px;
    font-weight:700;
    padding:6px 12px;
    border-radius:4px;
}
</style>

<h1 class="page-title">商品一覧</h1>

{{-- タブ --}}
<div style="
    width:85%;
    margin:0 auto 20px;
    display:flex;
    gap:30px;
    border-bottom:1px solid #ddd;
">
    <a href="{{ route('items.index') }}"
       style="
        padding-bottom:10px;
        font-weight:700;
        text-decoration:none;
        color:{{ request('tab') !== 'like' ? '#e60033' : '#333' }};
        border-bottom:{{ request('tab') !== 'like' ? '2px solid #e60033' : 'none' }};
       ">
        おすすめ
    </a>

    <a href="{{ route('items.index', ['tab' => 'like']) }}"
       style="
        padding-bottom:10px;
        font-weight:700;
        text-decoration:none;
        color:{{ request('tab') === 'like' ? '#e60033' : '#333' }};
        border-bottom:{{ request('tab') === 'like' ? '2px solid #e60033' : 'none' }};
       ">
        マイリスト
    </a>
</div>

{{-- 商品一覧 --}}
<div class="items-grid">

@forelse($items as $item)

    <a href="{{ route('items.show', $item) }}" class="items-box">

        {{-- ❤️ いいね --}}
        @auth
        @php
            $liked = auth()->user()->likedItems->contains($item->id);
        @endphp

        <form
            method="POST"
            action="{{ $liked
                ? route('likes.destroy', $item)
                : route('likes.store', $item) }}"
            style="position:absolute; top:12px; right:12px; z-index:10;"
            onclick="event.stopPropagation();"
        >
            @csrf
            @if($liked)
                @method('DELETE')
            @endif

            <button
                type="submit"
                style="
                    background:none;
                    border:none;
                    font-size:22px;
                    cursor:pointer;
                    color:{{ $liked ? '#ff5555' : '#ccc' }};
                "
                title="マイリスト"
            >
                {{ $liked ? '♥️' : '♡' }}
            </button>
            <span style="font-size:13px;color:#666;">
                {{ $item->liked_users_count }}
            </span>
        </form>
        @endauth

        {{-- Sold --}}
        @if($item->is_sold)
            <div class="sold-badge">Sold</div>
        @endif

        {{-- 画像 --}}
        <img
            class="items-img"
            src="{{ Str::startsWith($item->image,['http://','https://'])
                ? $item->image
                : asset('images/dummy.png') }}"
        >

        {{-- タイトル --}}
        <div class="items-title">{{ $item->title }}</div>

        {{-- 価格 --}}
        <div class="items-price">
            ¥{{ number_format($item->price) }}
        </div>

    </a>

@empty
    <p style="grid-column:1/-1; text-align:center;">
        商品がありません
    </p>
@endforelse

</div>

@endsection
