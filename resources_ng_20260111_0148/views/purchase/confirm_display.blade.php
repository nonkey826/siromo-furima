@extends('layouts.app')

@section('content')
<div class="container">
    <h1>購入確認</h1>

    <h3>商品情報</h3>
    <p>{{ $item->title }}</p>
    <p>¥{{ number_format($item->price) }}</p>

    <h3>配送先</h3>
    <p>〒{{ $user->postal_code }}</p>
    <p>{{ $user->address }}</p>
    <p>{{ $user->building }}</p>

    <a href="{{ route('purchase.payment', $item) }}">
        支払い方法を選択する
    </a>
</div>
@endsection
