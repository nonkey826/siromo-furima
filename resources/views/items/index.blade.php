@extends('layouts.app')

@section('title', '商品一覧')

@section('content')

<style>
    .items-wrap{
        display:grid;
        grid-template-columns: repeat(3, 1fr);
        gap:40px;
        margin-top:40px;
        width:90%;
        margin-left:auto;
        margin-right:auto;
    }

    .item-box{
        background:#fff;
        padding:10px;
        border-radius:6px;
        transition:.2s;
    }

    .item-box:hover{
        transform:translateY(-5px);
        opacity:.9;
    }

    .item-image{
        width:100%;
        height:240px;
        object-fit:cover;
        border-radius:4px;
        background:#ddd;
    }

    .item-title{
        font-size:18px;
        font-weight:700;
        color:#333;
        margin-top:12px;
        display:block;
    }

    .item-price{
        font-size:15px;
        font-weight:700;
        margin-top:6px;
        color:#ff6161;
    }
</style>


<h1 style="width:90%; margin:35px auto 0; font-weight:700;">商品一覧</h1>

<div class="items-wrap">

@foreach ($items as $item)

    <a href="{{ route('items.show', $item) }}" class="item-box" style="text-decoration:none; color:#333;">

        {{-- 画像 --}}
        <img
            class="item-image"
            src="{{ Str::startsWith($item->image, ['http://', 'https://'])
                ? $item->image
                : asset('images/dummy.png') }}"
        >

        {{-- タイトル --}}
        <span class="item-title">{{ $item->title }}</span>

        {{-- 金額 --}}
        <div class="item-price">
            ¥{{ number_format($item->price) }}（税込）
        </div>

    </a>

@endforeach

</div>

@endsection
