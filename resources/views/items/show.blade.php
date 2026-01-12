@extends('layouts.app')

@section('title', $item->title)

@section('content')

<style>
/* ===============================
   全体
=============================== */
.item-detail-wrap{
    max-width: 900px;
    margin: 40px auto 80px;
    padding: 0 16px;
}

/* ===============================
   上段（画像＋情報）
=============================== */
.item-main{
    display:flex;
    gap:40px;
}

.item-image{
    width:380px;
    height:380px;
    object-fit:cover;
    background:#ddd;
    border-radius:8px;
}

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
    margin-bottom:12px;
}

.item-meta{
    display:flex;
    align-items:center;
    gap:24px;
    margin-bottom:20px;
    font-size:14px;
    color:#555;
}

.purchase-btn{
    display:block;
    width:100%;
    padding:14px;
    background:#ff5555;
    color:#fff;
    text-align:center;
    font-weight:700;
    border-radius:8px;
    text-decoration:none;
}

.sold-text{
    margin-top:20px;
    font-weight:700;
    color:#999;
}

/* ===============================
   セクション
=============================== */
.section{
    margin-top:50px;
}

.section-title{
    font-size:18px;
    font-weight:700;
    margin-bottom:12px;
}

.item-info-row{
    display:flex;
    margin-bottom:10px;
    font-size:14px;
}

.item-info-label{
    width:120px;
    font-weight:700;
}

/* ===============================
   コメント
=============================== */
.comment-box{
    margin-bottom:20px;
}

.comment-user{
    display:flex;
    align-items:center;
    gap:8px;
    font-weight:700;
    margin-bottom:6px;
}

.user-icon{
    width:32px;
    height:32px;
    border-radius:50%;
    object-fit:cover;
}

/* ===============================
   スマホ対応
=============================== */
@media (max-width: 768px) {

    .item-main{
        flex-direction:column;
        gap:20px;
    }

    .item-image{
        width:100%;
        height:auto;
        aspect-ratio: 1 / 1;
    }

    .item-title{
        font-size:22px;
    }

    .item-price{
        font-size:20px;
    }

    .item-meta{
        gap:16px;
        flex-wrap:wrap;
    }

    .item-info-row{
        flex-direction:column;
        gap:4px;
    }

    .item-info-label{
        width:auto;
    }

    .section{
        margin-top:36px;
    }
}
</style>

<div class="item-detail-wrap">

    {{-- ===== 上段 ===== --}}
    <div class="item-main">

        {{-- 商品画像 --}}
        <img
            class="item-image"
            src="{{ $item->image
                ? asset('storage/' . $item->image)
                : asset('images/dummy.png') }}"
            alt="商品画像"
        >

        {{-- 商品情報 --}}
        <div class="item-right">

            <h1 class="item-title">{{ $item->title }}</h1>

            <div class="item-price">
                ¥{{ number_format($item->price) }}（税込）
            </div>

            <div class="item-meta">

                {{-- いいね --}}
                @auth
                    @php
                        $liked = auth()->user()->likedItems->contains($item->id);
                    @endphp

                    <form
                        method="POST"
                        action="{{ $liked ? route('likes.destroy', $item) : route('likes.store', $item) }}"
                        style="display:flex;align-items:center;gap:6px;"
                    >
                        @csrf
                        @if($liked)
                            @method('DELETE')
                        @endif

                        <button
                            type="submit"
                            style="background:none;border:none;font-size:22px;cursor:pointer;color:{{ $liked ? '#ff5555' : '#ccc' }};"
                        >
                            {{ $liked ? '♥️' : '♡' }}
                        </button>

                        <span>{{ $item->likedUsers->count() }}</span>
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
        <p>{{ $item->description }}</p>
    </div>

    {{-- ===== 商品情報 ===== --}}
    <div class="section">
        <div class="section-title">商品の情報</div>

        <div class="item-info-row">
            <div class="item-info-label">カテゴリー</div>
            <div>{{ $item->category ?? '-' }}</div>
        </div>

        <div class="item-info-row">
            <div class="item-info-label">商品の状態</div>
            <div>{{ $item->status ?? '-' }}</div>
        </div>
    </div>

    {{-- ===== 配送先 ===== --}}
    @if($address)
        <div class="section">
            <div class="section-title">配送先情報</div>
            <p>〒{{ $address->postal_code }}</p>
            <p>{{ $address->address }}</p>
            @if(!empty($address->building_name))
                <p>{{ $address->building_name }}</p>
            @endif
        </div>
    @endif

    {{-- ===== コメント ===== --}}
    <div class="section">
        <div class="section-title">
            コメント（{{ $item->comments->count() }}）
        </div>

        @foreach($item->comments as $comment)
            <div class="comment-box">
                <div class="comment-user">
                    <img
                        src="{{ asset('images/user-default.png') }}"
                        alt="ユーザーアイコン"
                        class="user-icon"
                    >
                    <span>{{ $comment->user->name }}</span>
                </div>
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
                    style="width:100%;padding:12px;border-radius:8px;border:1px solid #ccc;resize:none;"
                ></textarea>

                <button
                    style="width:100%;margin-top:12px;padding:14px;background:#ff5555;color:#fff;font-weight:700;border:none;border-radius:8px;"
                >
                    コメントを送信する
                </button>
            </form>
        </div>
    @endauth

</div>

@endsection

