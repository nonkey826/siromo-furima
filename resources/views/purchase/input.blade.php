@extends('layouts.app')

@section('title', '商品購入')

@section('content')

<style>
.purchase-wrapper {
    width:85%;
    margin:40px auto;
    display:flex;
    gap:40px;
}

/* 左 */
.purchase-left {
    flex:1;
}

/* 右 */
.purchase-right {
    width:320px;
}

.purchase-box {
    border:1px solid #1b1818e1;
    padding:20px;
    margin-bottom:20px;
}

.item-row {
    display:flex;
    gap:20px;
    margin-bottom:30px;
}

.item-img {
    width:140px;
    height:140px;
    background:#ddd;
    object-fit:cover;
}

.section {
    border-top:1px solid #1b1818e1;
    border-bottom:1px solid #1b1818e1;
    padding:20px 0;
}

.buy-btn {
    width:100%;
    background:#ff5555;
    color:#fff;
    border:none;
    padding:14px;
    font-size:16px;
    font-weight:700;
    border-radius:4px;
    cursor:pointer;
}
</style>

<div class="purchase-wrapper">

    {{-- 左側 --}}
    <div class="purchase-left">

        {{-- 商品情報 --}}
        <div class="item-row">
            <img
                class="item-img"
                src="{{ Str::startsWith($item->image, ['http://','https://'])
                        ? $item->image
                        : asset('images/dummy.png') }}"
            >
            <div>
                <h2>{{ $item->title }}</h2>
                <p style="color:#e60033;font-weight:700;">
                    ¥{{ number_format($item->price) }}
                </p>
            </div>
        </div>

        {{-- 支払い方法 --}}
        <div class="section">
            <h3>支払い方法</h3>
            <select name="payment_method" form="purchase-form">
                <option value="card">クレジットカード（Stripe）</option>
                <option value="convenience">コンビニ払い</option>
            </select>
        </div>

        {{-- 配送先 --}}
        <div class="section">
            <h3>配送先</h3>

            @if ($address)
                <p>
                    〒{{ $address->zipcode }}<br>
                    {{ $address->address }}<br>
                    {{ $address->building }}
                </p>
            @else
                <p>配送先住所が登録されていません。</p>
            @endif

            <a href="{{ route('address.edit', ['item' => $item->id]) }}">
                配送先を変更
            </a>
        </div>

    </div>

    {{-- 右側 --}}
    <div class="purchase-right">
        <div class="purchase-box">
            <p>商品代金</p>
            <p style="font-weight:700;">
                ¥{{ number_format($item->price) }}
            </p>

            <p style="margin-top:10px;">支払い方法</p>
            <p>クレジットカード</p>

            <form
                id="purchase-form"
                method="POST"
                action="{{ route('item.purchase', $item) }}"
            >
                @csrf
                <input type="hidden" name="payment_method" value="card">
                <button type="submit" class="buy-btn">
                    購入する
                </button>
            </form>
        </div>
    </div>

</div>

@endsection

