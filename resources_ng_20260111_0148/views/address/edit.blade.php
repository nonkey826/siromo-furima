@extends('layouts.app')

@section('title', '住所の変更')

@section('content')
<div style="max-width:900px;margin:40px auto;">
    <h1 style="font-size:22px;font-weight:700;margin-bottom:24px;">
        住所の変更
    </h1>

    {{-- フラッシュメッセージ --}}
    @if (session('success'))
        <div style="background:#e6ffed;border:1px solid #a7f3d0;padding:10px 14px;margin-bottom:16px;font-size:14px;">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div style="background:#fee2e2;border:1px solid #fecaca;padding:10px 14px;margin-bottom:16px;font-size:14px;">
            {{ session('error') }}
        </div>
    @endif

    {{-- バリデーションエラー --}}
    @if ($errors->any())
        <div style="background:#fee2e2;border:1px solid #fecaca;padding:10px 14px;margin-bottom:16px;font-size:14px;">
            入力内容を確認してください。
        </div>
    @endif

    <div style="
        background:#fff;
        padding:32px 40px;
        border-radius:6px;
        box-shadow:0 0 8px rgba(0,0,0,0.06);
    ">
        <form method="POST" action="{{ route('address.update') }}">
            @csrf
            @method('PUT')

            {{-- 🔑 購入画面から来た場合の商品ID --}}
            @if(request('item'))
                <input type="hidden" name="item_id" value="{{ request('item') }}">
            @endif

            {{-- 郵便番号 --}}
            <div style="margin-bottom:20px;">
                <label style="display:block;font-size:14px;margin-bottom:6px;">
                    郵便番号
                </label>
                <input
                    type="text"
                    name="zipcode"
                    value="{{ old('zipcode', $address->zipcode ?? '') }}"
                    style="width:100%;max-width:480px;padding:8px 10px;border:1px solid #ccc;border-radius:4px;"
                >
            </div>

            {{-- 住所 --}}
            <div style="margin-bottom:20px;">
                <label style="display:block;font-size:14px;margin-bottom:6px;">
                    住所
                </label>
                <input
                    type="text"
                    name="address"
                    value="{{ old('address', $address->address ?? '') }}"
                    style="width:100%;max-width:480px;padding:8px 10px;border:1px solid #ccc;border-radius:4px;"
                >
            </div>

            {{-- 建物名 --}}
            <div style="margin-bottom:32px;">
                <label style="display:block;font-size:14px;margin-bottom:6px;">
                    建物名
                </label>
                <input
                    type="text"
                    name="building"
                    value="{{ old('building', $address->building ?? '') }}"
                    style="width:100%;max-width:480px;padding:8px 10px;border:1px solid #ccc;border-radius:4px;"
                >
            </div>

            <div style="text-align:center;">
                <button
                    type="submit"
                    style="
                        min-width:200px;
                        padding:10px 24px;
                        background:#ff6f6f;
                        color:#fff;
                        font-weight:700;
                        border:none;
                        border-radius:4px;
                    "
                >
                    更新する
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
