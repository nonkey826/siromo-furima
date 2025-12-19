@extends('layouts.app')

@section('title', '住所変更')

@section('content')

<div class="container py-5">

    <h1 class="mb-4">配送先住所の編集</h1>

    {{-- ▼成功メッセージ --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- ▼エラー表示 --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            入力内容を確認してください。
        </div>
    @endif

    <form action="{{ route('address.update') }}" method="POST" class="card p-4">
        @csrf
        @method('PUT')

        {{-- 郵便番号 --}}
        <div class="mb-3">
            <label class="form-label">郵便番号</label>
            <input
                type="text"
                name="zipcode"
                class="form-control"
                value="{{ old('zipcode', $address->zipcode ?? '') }}"
            >
        </div>

        {{-- 都道府県 --}}
        <div class="mb-3">
            <label class="form-label">都道府県</label>
            <input
                type="text"
                name="prefecture"
                class="form-control"
                value="{{ old('prefecture', $address->prefecture ?? '') }}"
            >
        </div>

        {{-- 市区町村 --}}
        <div class="mb-3">
            <label class="form-label">市区町村</label>
            <input
                type="text"
                name="city"
                class="form-control"
                value="{{ old('city', $address->city ?? '') }}"
            >
        </div>

        {{-- 丁目番地 --}}
        <div class="mb-3">
            <label class="form-label">丁目・番地</label>
            <input
                type="text"
                name="street"
                class="form-control"
                value="{{ old('street', $address->street ?? '') }}"
            >
        </div>

        {{-- 建物名 --}}
        <div class="mb-3">
            <label class="form-label">建物名・部屋番号 (任意)</label>
            <input
                type="text"
                name="building"
                class="form-control"
                value="{{ old('building', $address->building ?? '') }}"
            >
        </div>

        <div class="mt-4 d-flex gap-3">

            <button class="btn btn-primary w-50">
                更新する
            </button>

            <a href="{{ url()->previous() }}"
   class="btn btn-secondary w-50 text-center">
    戻る
</a>


        </div>

    </form>

</div>

@endsection
