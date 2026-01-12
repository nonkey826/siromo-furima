@extends('layouts.app')

@section('title', '商品出品')

@section('content')

<div class="form-container">
    <h1 class="page-title">商品の出品</h1>

    {{-- ▼ バリデーションエラー表示 --}}
    @if ($errors->any())
        <div style="color:red; margin-bottom:20px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- ★ enctype を必ず指定 --}}
    <form method="POST"
          action="{{ route('items.store') }}"
          enctype="multipart/form-data">
        @csrf

        <h2 class="section-title">商品の詳細</h2>

        {{-- カテゴリー --}}
        <label>カテゴリー</label>
        <div class="category-list">
            @foreach ([
                'ファッション','家電','インテリア','レディース','メンズ','コスメ',
                '本','ゲーム','スポーツ','キッチン','ハンドメイド','アクセサリー',
                'おもちゃ','ベビー・キッズ'
            ] as $category)
                <label class="category-item">
                    <input
                        type="radio"
                        name="category"
                        value="{{ $category }}"
                        {{ old('category') === $category ? 'checked' : '' }}
                    >
                    <span>{{ $category }}</span>
                </label>
            @endforeach
        </div>

        {{-- 商品画像（★URL入力ではなくファイルアップロード） --}}
        <label>商品画像（JPG / PNG）</label>
        <input
            type="file"
            name="image"
            class="input"
            accept="image/jpeg,image/png"
        >

        {{-- 商品の状態 --}}
        <label class="form-label">商品の状態</label>
        <select name="status" class="input">
            <option value="">選択してください</option>
            @foreach ([
                '新品',
                '未使用に近い',
                '良好',
                '目立った傷や汚れなし',
                'やや傷や汚れあり',
                '傷や汚れあり'
            ] as $status)
                <option
                    value="{{ $status }}"
                    {{ old('status') === $status ? 'selected' : '' }}
                >
                    {{ $status }}
                </option>
            @endforeach
        </select>

        {{-- 商品名 --}}
        <label>商品名</label>
        <input
            type="text"
            name="title"
            class="input"
            value="{{ old('title') }}"
        >

        {{-- ブランド名（任意） --}}
        <label>ブランド名（任意）</label>
        <input
            type="text"
            name="brand"
            class="input"
            value="{{ old('brand') }}"
        >

        {{-- 商品説明 --}}
        <label>商品の説明</label>
        <textarea
            name="description"
            class="textarea"
        >{{ old('description') }}</textarea>

        {{-- 価格 --}}
        <label>価格</label>
        <input
            type="number"
            name="price"
            class="input"
            value="{{ old('price') }}"
        >

        {{-- 出品ボタン --}}
        <button type="submit" class="submit-btn">
            出品する
        </button>
    </form>
</div>

@endsection
