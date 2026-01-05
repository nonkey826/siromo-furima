@extends('layouts.app')

@section('title', '会員登録')

@section('content')
<div style="
    max-width:480px;
    margin:80px auto;
    padding:40px;
">

    <h2 style="text-align:center;margin-bottom:30px;">会員登録</h2>

    {{-- バリデーションエラー表示 --}}
    @if ($errors->any())
        <div style="color:red;margin-bottom:20px;">
            <ul style="padding-left:20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div style="margin-bottom:20px;">
            <label>ユーザー名</label>
            <input
                type="text"
                name="name"
                value="{{ old('name') }}"
                style="width:100%;padding:10px;"
            >
        </div>

        <div style="margin-bottom:20px;">
            <label>メールアドレス</label>
            <input
                type="email"
                name="email"
                value="{{ old('email') }}"
                style="width:100%;padding:10px;"
            >
        </div>

        <div style="margin-bottom:20px;">
            <label>パスワード</label>
            <input
                type="password"
                name="password"
                style="width:100%;padding:10px;"
            >
        </div>

        <div style="margin-bottom:30px;">
            <label>確認用パスワード</label>
            <input
                type="password"
                name="password_confirmation"
                style="width:100%;padding:10px;"
            >
        </div>

        <button
            type="submit"
            style="
                width:100%;
                padding:12px;
                background:#ef6b63;
                color:#fff;
                border:none;
                font-weight:bold;
                cursor:pointer;
            ">
            登録する
        </button>
    </form>

    <div style="text-align:center;margin-top:20px;">
        <a href="{{ route('login') }}" style="color:#1e73ff;">
            ログインはこちら
        </a>
    </div>

</div>
@endsection
