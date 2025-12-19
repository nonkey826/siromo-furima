@extends('layouts.app')

@section('title', '購入完了')

@section('content')

<div style="
    width:100%;
    max-width:800px;
    margin:40px auto;
    text-align:center;
    padding:50px 20px;
    background:#fff;
    border-radius:10px;
    box-shadow:0 0 10px rgba(0,0,0,0.1);
">

    {{-- 完了タイトル --}}
    <h1 style="margin-bottom:25px; font-size:30px; font-weight:bold;">
        ご購入ありがとうございました！
    </h1>

    {{-- 商品情報 --}}
    <div style="margin-bottom:35px;">
        <h2 style="font-size:20px; margin-bottom:10px;">
            {{ $item->title }}
        </h2>

        @php
            use Illuminate\Support\Str;
        @endphp

        <img
            src="{{ Str::startsWith($item->image, ['http://', 'https://']) 
                    ? $item->image
                    : asset('images/dummy.png') }}"
            alt="{{ $item->title }}"
            style="width:250px; margin-bottom:15px; border-radius:5px;"
        >

        <p style="font-size:18px; font-weight:bold;">
            ¥{{ number_format($item->price) }}
        </p>
    </div>

    {{-- メッセージ --}}
    <p style="font-size:16px; margin-bottom:35px;">
        ご購入手続きが正常に完了しました。  
        発送準備が整いましたらご連絡いたします。
    </p>

    {{-- ボタン類 --}}
    <div style="margin-bottom:20px;">
        <a href="{{ route('mypage.index') }}"
           style="
                display:inline-block;
                background:#3490dc;
                color:#fff;
                padding:12px 25px;
                border-radius:6px;
                text-decoration:none;
                margin:5px;
        ">
            マイページへ戻る
        </a>

        <a href="{{ route('items.index') }}"
           style="
                display:inline-block;
                background:#444;
                color:#fff;
                padding:12px 25px;
                border-radius:6px;
                text-decoration:none;
                margin:5px;
        ">
            商品一覧へ戻る
        </a>
    </div>

</div>

@endsection
