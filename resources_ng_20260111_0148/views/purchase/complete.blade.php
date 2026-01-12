@extends('layouts.app')

@section('title', '購入完了')

@section('content')

<style>
/* =========================
   レイアウト
========================= */
.complete-wrapper {
    width: 100%;
    max-width: 800px;
    margin: 40px auto;
    padding: 50px 20px;
    text-align: center;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}

/* =========================
   タイトル
========================= */
.complete-title {
    margin-bottom: 25px;
    font-size: 30px;
    font-weight: 700;
}

/* =========================
   商品情報
========================= */
.complete-item {
    margin-bottom: 35px;
}

.complete-item-title {
    font-size: 20px;
    margin-bottom: 10px;
    font-weight: 700;
}

.complete-item-img {
    width: 250px;
    max-width: 100%;
    margin-bottom: 15px;
    border-radius: 5px;
    object-fit: cover;
}

.complete-item-price {
    font-size: 18px;
    font-weight: 700;
}

/* =========================
   メッセージ
========================= */
.complete-message {
    font-size: 16px;
    margin-bottom: 35px;
    line-height: 1.7;
}

/* =========================
   ボタン
========================= */
.complete-buttons a {
    display: inline-block;
    padding: 12px 25px;
    border-radius: 6px;
    text-decoration: none;
    margin: 5px;
    font-weight: 600;
}

.btn-mypage {
    background: #3490dc;
    color: #fff;
}

.btn-items {
    background: #444;
    color: #fff;
}

/* =========================
   スマホ対応
========================= */
@media (max-width: 768px) {

    .complete-wrapper {
        margin: 20px auto;
        padding: 30px 16px;
    }

    .complete-title {
        font-size: 24px;
    }

    .complete-item-img {
        width: 100%;
        max-height: 260px;
    }

    .complete-message {
        font-size: 15px;
    }
}
</style>

<div class="complete-wrapper">

    {{-- 完了タイトル --}}
    <h1 class="complete-title">
        ご購入ありがとうございました！
    </h1>

    {{-- 商品情報 --}}
    <div class="complete-item">

        <p class="complete-item-title">
            {{ $item->title }}
        </p>

        <img
            class="complete-item-img"
            src="{{ $item->image
                    ? asset('storage/' . $item->image)
                    : asset('images/dummy.png') }}"
            alt="{{ $item->title }}"
        >

        <p class="complete-item-price">
            ¥{{ number_format($item->price) }}
        </p>
    </div>

    {{-- メッセージ --}}
    <p class="complete-message">
        ご購入手続きが正常に完了しました。<br>
        発送準備が整いましたらご連絡いたします。
    </p>

    {{-- ボタン --}}
    <div class="complete-buttons">
        <a href="{{ route('mypage.index') }}" class="btn-mypage">
            マイページへ戻る
        </a>

        <a href="{{ route('items.index') }}" class="btn-items">
            商品一覧へ戻る
        </a>
    </div>

</div>

@endsection
