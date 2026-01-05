@extends('layouts.app')

@section('title', $item->title)

@section('content')

<style>
/* ===== 全体 ===== */
.item-detail-wrap{
    width:900px;
    margin:40px auto 80px;
}

/* ===== 上段 ===== */
.item-main{
    display:flex;
    align-items:flex-start;
    gap:40px;
}

/* 左：画像 */
.item-image{
    width:380px;
    height:380px;
    flex-shrink:0;
    object-fit:cover;
    background:#ddd;
    border-radius:6px;
}

/* 右：情報 */
.item-right{
    flex:1;
}

.item-title{
    font-size:26px;
    font-weight:700;
    margin-bottom:8px;
}

.item-price{
    font-size:22px;
    font-weight:700;
    color:#ff5555;
    margin-bottom:10px;
}

/* いいね・コメント数 */
.item-meta{
    display:flex;
    align-items:center;
    gap:24px;
    margin-bottom:20px;
    font-size:14px;
    color:#555;
}

/* 購入ボタン */
.purchase-btn{
    display:block;
    width:100%;
    padding:14px 10px;
    background:#ff5555;
    color:#fff;
    text-align:center;
    font-weight:700;
    border-radius:6px;
    text-decoration:none;
    border:none;
}

/* Sold */
.sold-text{
    margin-top:20px;
    font-weight:700;
    color:#999;
}

/* ===== セクション ===== */
.section{
    margin-top:50px;
}

.section-title{
    font-size:18px;
    font-weight:700;
    margin-bottom:12px;
}

.item-description{
    line-height:1.8;
    font-size:15px;
}

/* ===== 商品情報 ===== */
.item-info-row{
    display:flex;
    align-items:center;
    margin-bottom:12px;
    font-size:14px;
}

.item-info-label{
    width:120px;
    font-weight:700;
}

.item-tag{
    padding:4px 12px;
    background:#eee;
    border-radius:20px;
    font-size:13px;
}

/* ===== コメント ===== */
.comment-box{
    margin-bottom:16px;
}

.comment-user{
    font-weight:700;
    font-size:14px;
    margin-bottom:6px;
}
</style>

<div class="item-detail-wrap">

    {{-- ===== 上段 ===== --}}
    <div class="item-main">

        {{-- 画像 --}}
        <img
            src="{{ Str::startsWith($item->image,['http://','https://'])
                ? $item->image
                : asset('images/dummy.png') }}"
            class="item-image"
        >

        {{-- 情報 --}}
        <div class="item-right">

            <h1 class="item-title">{{ $item->title }}</h1>

            <div class="item-price">
                ¥{{ number_format($item->price) }}（税込）
            </div>

            <div class="item-meta">

                {{-- ❤️ いいね（一覧と完全同期） --}}
                @auth
                    @php
                        $liked = auth()->user()
                            ->likedItems
                            ->contains($item->id);
                    @endphp

                    <form
                        method="POST"
                        action="{{ $liked
                            ? route('likes.destroy', $item)
                            : route('likes.store', $item) }}"
                        style="display:flex;align-items:center;gap:6px;"
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
                        >
                            {{ $liked ? '♥️' : '♡' }}
                        </button>

                        <span style="font-size:14px;color:#666;">
                            {{ $item->likedUsers->count() }}
                        </span>
                    </form>
                @endauth

                {{-- コメント数 --}}
                <span>💬 {{ $item->comments->count() }}</span>
            </div>

            {{-- 購入 --}}
            @auth
                @if($item->user_id !== auth()->id() && !$item->is_sold)
                    <a href="{{ route('purchase.input', $item) }}" class="purchase-btn">
                        購入手続きへ
                    </a>
                @endif
            @endauth

            @if($item->is_sold)
                <div class="sold-text">この商品は売り切れました</div>
            @endif

        </div>
    </div>

    {{-- ===== 商品説明 ===== --}}
    <div class="section">
        <div class="section-title">商品説明</div>
        <p class="item-description">{{ $item->description }}</p>
    </div>

    {{-- ===== 商品情報 ===== --}}
    <div class="section">
        <div class="section-title">商品の情報</div>

        <div class="item-info-row">
            <div class="item-info-label">カテゴリー</div>
            <div>
                {{ $item->category ?? '-' }}
            </div>
        </div>

        <div class="item-info-row">
            <div class="item-info-label">商品の状態</div>
            <div>{{ $item->status ?? '-' }}</div>
        </div>
    </div>

    {{-- ===== コメント ===== --}}
    <div class="section">
        <div class="section-title">
            コメント（{{ $item->comments->count() }}）
        </div>

        @foreach($item->comments as $comment)
            <div class="comment-box">
                <div class="comment-user">{{ $comment->user->name }}</div>
                <p>{{ $comment->comment }}</p>
            </div>
        @endforeach
    </div>

    {{-- ===== コメント投稿 ===== --}}
    @auth
    <div class="section">
        <div class="section-title">商品へのコメント</div>

        <form action="{{ route('comments.store', $item) }}" method="POST">
            @csrf

            <textarea
                name="comment"
                rows="4"
                placeholder="コメントを入力してください"
                style="
                    width:100%;
                    padding:12px;
                    border-radius:6px;
                    border:1px solid #ccc;
                    resize:none;
                "
            ></textarea>

            <button
                style="
                    width:100%;
                    margin-top:12px;
                    padding:14px;
                    background:#ff5555;
                    color:#fff;
                    font-weight:700;
                    border:none;
                    border-radius:6px;
                "
            >
                コメントを送信する
            </button>
        </form>
    </div>
    @endauth

</div>

@endsection


