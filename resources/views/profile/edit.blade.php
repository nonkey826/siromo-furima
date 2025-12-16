@extends('layouts.app')

@section('title', 'プロフィール編集')

@section('content')
<div class="profile-edit">
    <h1>プロフィール編集</h1>

    {{-- バリデーションエラー表示 --}}
    @if ($errors->any())
        <div class="error-messages">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}">
        @csrf

        {{-- ニックネーム --}}
        <div class="form-group">
            <label>ニックネーム</label>
            <input
                type="text"
                name="nickname"
                value="{{ old('nickname', $profile->nickname ?? '') }}"
            >
        </div>

        {{-- 郵便番号 --}}
        <div class="form-group">
            <label>郵便番号</label>
            <input
                type="text"
                name="postal_code"
                value="{{ old('postal_code', $address->postal_code ?? '') }}"
            >
        </div>

        {{-- 住所 --}}
        <div class="form-group">
            <label>住所</label>
            <input
                type="text"
                name="address"
                value="{{ old('address', $address->address ?? '') }}"
            >
        </div>

        {{-- 建物名 --}}
        <div class="form-group">
            <label>建物名</label>
            <input
                type="text"
                name="building"
                value="{{ old('building', $address->building ?? '') }}"
            >
        </div>

        <button type="submit">保存</button>
    </form>
</div>
@endsection
