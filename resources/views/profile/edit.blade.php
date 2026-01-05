@extends('layouts.app')

@section('title', 'プロフィール編集')

@section('content')

<div style="max-width:900px;margin:40px auto;">

    <h1 style="font-size:22px;font-weight:700;margin-bottom:34px;">
        プロフィール設定
    </h1>

    {{-- エラー --}}
    @if ($errors->any())
        <div style="background:#fee2e2;border:1px solid #fecaca;padding:12px;margin-bottom:20px;">
            入力内容に誤りがあります。
        </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        @method('PUT')

        {{-- アイコン枠 --}}
        <div style="text-align:center;margin-bottom:30px;">
            <div style="
                width:120px;height:120px;border-radius:50%;
                background:#ccc;margin:0 auto 12px;
            "></div>

            <label style="
                display:inline-block;
                padding:6px 12px;
                border:1px solid #aaa;
                font-size:14px;
                cursor:pointer;
            ">
                画像を選択する
            </label>
        </div>

        {{-- ======================
            ニックネーム
        ======================= --}}
        <label style="font-size:14px;font-weight:700;display:block;margin-bottom:6px;">
            ユーザー名
        </label>

        <input
            type="text"
            name="nickname"
            value="{{ old('nickname', $user->profile->nickname ?? '') }}"
            style="
                width:100%;
                border:1px solid #ccc;
                border-radius:6px;
                padding:12px;
                margin-bottom:22px;
            "
            required
        >

        {{-- ======================
            郵便番号
        ======================= --}}
        <label style="font-size:14px;font-weight:700;display:block;margin-bottom:6px;">
            郵便番号
        </label>

        <input
            type="text"
            name="postal_code"
            value="{{ old('postal_code', $user->address->zipcode ?? '') }}"
            style="
                width:100%;
                border:1px solid #ccc;
                border-radius:6px;
                padding:12px;
                margin-bottom:22px;
            "
        >

        {{-- ======================
            住所
        ======================= --}}
        <label style="font-size:14px;font-weight:700;display:block;margin-bottom:6px;">
            住所
        </label>

        <input
            type="text"
            name="address"
            value="{{ old('address', $user->address->address ?? '') }}"
            style="
                width:100%;
                border:1px solid #ccc;
                border-radius:6px;
                padding:12px;
                margin-bottom:22px;
            "
        >

        {{-- ======================
            建物名
        ======================= --}}
        <label style="font-size:14px;font-weight:700;display:block;margin-bottom:6px;">
            建物名
        </label>

        <input
            type="text"
            name="building"
            value="{{ old('building', $user->address->building ?? '') }}"
            style="
                width:100%;
                border:1px solid #ccc;
                border-radius:6px;
                padding:12px;
                margin-bottom:32px;
            "
        >

        {{-- ======================
            保存ボタン
        ======================= --}}
        <button
            type="submit"
            style="
                width:100%;
                padding:14px;
                background:#ff6f6f;
                color:#fff;
                border:none;
                border-radius:6px;
                font-size:16px;
                font-weight:bold;
                cursor:pointer;
            "
        >
            更新する
        </button>

    </form>

</div>

@endsection

