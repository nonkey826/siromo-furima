@extends('layouts.app')

@section('title', '購入確認')

@section('content')

<div class="container py-5">

    <h1 class="mb-4">購入内容の確認</h1>

    <div class="row">

        {{-- 左 --}}
        <div class="col-md-8">

            {{-- 商品 --}}
            <div class="card mb-4">
                <div class="row g-0">

                    <div class="col-md-4 p-3 d-flex align-items-center justify-content-center">

                        <img 
                            src="{{ $item->image }}"
                            class="img-fluid"
                            style="max-height:150px;"
                            alt="{{ $item->title }}"
                        >

                    </div>

                    <div class="col-md-8 p-3">

                        <h5>{{ $item->title }}</h5>

                        <p>
                            価格：
                            <strong>
                                ¥{{ number_format($item->price) }}
                            </strong>
                        </p>

                    </div>

                </div>
            </div>

            {{-- 配送先 --}}
            <div class="card p-3 mb-4">

                <h5 class="mb-3">配送先</h5>

                @if(!empty($address))

                    <p class="mb-0">
                        〒{{ $address->postal_code }}<br>
                        {{ $address->address }}<br>

                        @if(!empty($address->building))
                            {{ $address->building }}
                        @endif
                    </p>

                    <a href="{{ route('address.edit') }}" class="d-inline-block mt-2">
                        変更する
                    </a>

                @else

                    <p class="text-danger">
                        配送先住所が登録されていません
                    </p>

                    <a href="{{ route('address.edit') }}" class="d-inline-block mt-2">
                        登録する
                    </a>

                @endif

            </div>

            {{-- 戻るボタン --}}
            <div class="d-flex gap-3">

                {{-- 支払い方法に戻る --}}
                <a href="{{ route('purchase.input', $item) }}"
                    class="btn btn-outline-secondary w-50">
                    支払い方法選択に戻る
                </a>

                {{-- 商品詳細に戻る --}}
                <a href="{{ route('items.show', $item) }}"
                    class="btn btn-outline-dark w-50">
                    商品詳細に戻る
                </a>

            </div>

        </div>


        {{-- 右 --}}
        <div class="col-md-4">

            <div class="card p-4">

                <h5 class="mb-3">支払い金額</h5>

                <p class="fs-4 fw-bold">
                    ¥{{ number_format($item->price) }}
                </p>

                <form action="{{ route('item.purchase', $item) }}" method="POST">

                    @csrf

                    <input 
                        type="hidden" 
                        name="payment_method" 
                        value="{{ $paymentMethod }}"
                    >

                    <button 
                        class="btn btn-danger w-100 py-2 mt-3"
                    >
                        購入を確定する
                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection

