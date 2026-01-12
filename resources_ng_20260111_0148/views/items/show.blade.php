@extends('layouts.app')

@section('title', $item->title)

@section('content')

<style>
.item-detail-wrap{
    max-width:900px;
    margin:40px auto 80px;
    padding:0 16px;
}

.item-main{
    display:flex;
    gap:40px;
}

@media (max-width:768px){
    .item-main{
        flex-direction:column;
    }
}

.item-image{
    width:100%;
    max-width:380px;
    aspect-ratio:1/1;
    object-fit:cover;
    background:#ddd;
    border-radius:6px;
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

.purchase-btn{
    display:block;
    width:100%;
    padding:14px;
    background:#ff5555;
    color:#fff;
    text-align:center;
    font-weight:700;
    border-radius:6px;
    text-decoration:none;
}

.sold-text{
    margin-top:20px;
    font-weight:700;
    color:#999;
}
</style>

<div class="item-detail-wrap">

    <div class="item-main">

        <img
            class="item-image"
            src="{{ $item->image
                ? asset('storage/' . $item->image)
                : asset('images/dummy.png') }}"
            alt="商品画像"
        >

        <div class="item-right">

            <h1 class="item-title">{{ $item->title }}</h1>

            <div class="item-price">
                ¥{{ number_format($item->price) }}（税込）
            </div>

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

</div>

@endsection
