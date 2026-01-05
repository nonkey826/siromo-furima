@extends('layouts.app')

@section('title', 'ログイン')

@section('content')
<div style="display:flex;justify-content:center;align-items:center;min-height:70vh;">
    <div style="width:420px;padding:40px;">

        <h1 style="text-align:center;margin-bottom:30px;">ログイン</h1>

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

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div style="margin-bottom:20px;">
                <label style="display:block;margin-bottom:5px;">メールアドレス</label>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    style="width:100%;padding:10px;"
                >
            </div>

            <div style="margin-bottom:30px;">
                <label style="display:block;margin-bottom:5px;">パスワード</label>
                <input
                    type="password"
                    name="password"
                    style="width:100%;padding:10px;"
                >
            </div>

            <button
                type="submit"
                style="
                    width:100%;
                    padding:12px;
                    background:#ef6461;
                    color:#fff;
                    border:none;
                    font-size:16px;
                    font-weight:bold;
                    cursor:pointer;
                ">
                ログインする
            </button>
        </form>

        <div style="text-align:center;margin-top:20px;">
            <a href="{{ route('register') }}" style="color:#1e73ff;">
                会員登録はこちら
            </a>
        </div>

    </div>
</div>
@endsection
