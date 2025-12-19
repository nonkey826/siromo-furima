@extends('layouts.app')

@section('title', '支払い方法選択')

@section('content')
<div class="container py-5">

    <h1 class="mb-4">支払い方法を選択</h1>

    <form action="{{ route('purchase.confirm', $item) }}" method="POST">
        @csrf

        {{-- 支払い方法 --}}
        <div class="mb-3">
            <label>
                <input type="radio" name="payment_method" value="card" required>
                クレジットカード払い
            </label>
        </div>

        <div class="mb-3">
            <label>
                <input type="radio" name="payment_method" value="bank" required>
                銀行振込
            </label>
        </div>

        <button class="btn btn-primary w-100">
            確認画面へ
        </button>
    </form>

</div>
@endsection

