@extends('layouts.app')

@section('title', $item->name)

@section('content')

<div style="width:100%; max-width:1100px; margin:0 auto; padding:40px 0; display:flex; gap:50px;">

    {{-- 左：商品画像 --}}
    <div style="width:45%; background:#e3e3e3; height:550px; display:flex; align-items:center; justify-content:center; font-size:22px; color:#555;">
        商品画像
    </div>

    {{-- 右側エリア --}}
    <div style="width:55%;">

        {{-- 商品名 --}}
        <h2 style="font-size:28px; font-weight:700; margin-bottom:5px;">
            {{ $item->name }}
        </h2>

        {{-- ブランド --}}
        <p style="color:#777; margin-bottom:20px;">
            ブランド名
        </p>

        {{-- 価格 --}}
        <p style="font-size:28px; font-weight:700; margin-bottom:15px;">
            ¥{{ number_format($item->price) }} <span style="font-size:16px;">(税込)</span>
        </p>

        {{-- Like / コメント数 --}}
        <div style="display:flex; gap:25px; font-size:14px; margin-bottom:15px;">
            <div>♡ 3</div>
            <div>💬 1</div>
        </div>

        {{-- 購入ボタン --}}
@auth
    <a
        href="{{ route('purchase.input', $item) }}"
        style="
            display:block;
            width:280px;
            height:40px;
            background:#ff6f6f;
            color:#fff;
            text-align:center;
            line-height:40px;
            font-weight:700;
            border-radius:4px;
            text-decoration:none;
            margin-bottom:30px;
        "
    >
        購入手続きへ
    </a>
@endauth

@guest
    <a href="/login" class="btn btn-warning">
        ログインして購入
    </a>
@endguest



        @guest
            <p style="color:red;">購入にはログインが必要です。</p>
        @endguest

        {{-- 商品説明 --}}
        <h3 style="font-size:20px; font-weight:700; margin-bottom:10px;">
            商品説明
        </h3>

        <p style="margin-bottom:25px;">
            {{ $item->description }}
        </p>

        {{-- 商品の情報 --}}
        <h3 style="font-size:20px; font-weight:700; margin-bottom:12px;">
            商品の情報
        </h3>

        <table style="width:100%; margin-bottom:35px;">
            <tr>
                <td style="width:140px; color:#777;">カテゴリ</td>
                <td>{{ $item->category }}</td>
            </tr>
            <tr>
                <td style="width:140px; color:#777;">商品状態</td>
                <td>{{ $item->condition }}</td>
            </tr>
        </table>

        {{-- コメント --}}
        <h3 style="font-size:18px; font-weight:700; margin-bottom:10px;">
            コメント({{ $comments->count() }})
        </h3>

        {{-- コメント表示 --}}
        @foreach ($comments as $comment)
            <div style="padding:8px 0; border-bottom:1px solid #ddd;">
                <strong>{{ $comment->user->name }}</strong><br>
                {{ $comment->comment }}
            </div>
        @endforeach

        {{-- コメント投稿 --}}
        @auth
        <form action="{{ route('comments.store', $item) }}" method="POST" style="margin-top:20px;">
            @csrf

            <textarea
                name="comment"
                placeholder="商品のコメントを書いてください"
                required
                style="
                    width:100%;
                    height:120px;
                    border:1px solid #ccc;
                    border-radius:6px;
                    padding:10px;
                    margin-bottom:15px;
                "
            ></textarea>

            <button
                style="
                    width:100%;
                    height:40px;
                    background:#ff6f6f;
                    color:#fff;
                    border:none;
                    border-radius:6px;
                    font-weight:700;
                "
            >コメントを送信する</button>
        </form>
        @endauth

        @guest
        <p style="color:#777;">コメント投稿にはログインが必要です。</p>
        @endguest

    </div>
</div>

@endsection

