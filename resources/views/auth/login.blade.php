@extends('layouts.app')

@section('title', 'ログイン')

@section('content')

<div class="container py-5" style="max-width:480px;">

    <h1 class="mb-4 text-center fw-bold">ログイン</h1>

    {{-- エラー --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            ログイン情報が正しくありません。
        </div>
    @endif


    <form method="POST" action="{{ route('login') }}" class="card p-4 shadow-sm">
        @csrf

        {{-- メールアドレス --}}
        <div class="mb-3">
            <label class="form-label">メールアドレス</label>
            <input id="email" type="email"
                   class="form-control @error('email') is-invalid @enderror"
                   name="email"
                   value="{{ old('email') }}"
                   required autocomplete="email" autofocus>

            @error('email')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        {{-- パスワード --}}
        <div class="mb-3">
            <label class="form-label">パスワード</label>
            <input id="password" type="password"
                   class="form-control @error('password') is-invalid @enderror"
                   name="password"
                   required autocomplete="current-password">

            @error('password')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        {{-- ログインボタン --}}
        <button type="submit" class="btn btn-primary w-100 py-2 mt-2">
            ログイン
        </button>

        {{-- 新規登録 --}}
        <div class="text-center mt-3">
            <a href="{{ route('register') }}" class="text-decoration-none">
                新規登録はこちら
            </a>
        </div>

    </form>

</div>

@endsection

