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
    box-shadow: 0 2px 6px rgba(0,0,0,0.08);
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

@media screen and (max-width: 768px) {

    .page-title {
        font-size: 18px;
        margin: 10px auto;
    }

    .items-grid {
        gap: 16px;
        margin-bottom: 40px;
    }

    .items-img {
        height: 180px;
    }
}

/* ===== ふわっと出現 JS===== */
.items-box {
  opacity: 0;
  transform: translateY(18px);
}

.items-box.is-visible {
  opacity: 1;
  transform: translateY(0);
  transition: opacity .45s ease, transform .45s ease;
}

/* ===== ぬるっと浮く JS===== */
.items-box {
  transition: transform .25s ease, box-shadow .25s ease;
}
.items-box.is-hover {
  transform: translateY(-8px);
  box-shadow: 0 12px 26px rgba(0,0,0,.14);
}

/* ===== タブ切替フェード JS===== */
.items-grid.is-loading {
  opacity: .45;
  transition: opacity .2s ease;
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

<div
    class="like-area"
    style="position:absolute; top:12px; right:12px; z-index:10;"
    onclick="event.stopPropagation();"
>
    <button
        type="button"
        class="like-btn"
        data-item-id="{{ $item->id }}"
        data-liked="{{ $liked ? '1' : '0' }}"
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

    <span class="like-count" style="font-size:13px;color:#666;">
        {{ $item->liked_users_count }}
    </span>
</div>
@endauth


        {{-- Sold --}}
        @if($item->is_sold)
            <div class="sold-badge">Sold</div>
        @endif

        {{-- 画像 --}}
        <img
    class="items-img"
    src="{{ $item->image
        ? asset('storage/' . $item->image)
        : asset('images/dummy.png') }}"
    alt="商品画像"
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
