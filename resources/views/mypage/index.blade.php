@extends('layouts.app')

@section('title', 'マイページ')

@section('content')
<div class="mypage">

    <h1 class="mypage__title">マイページ</h1>

    {{-- プロフィール --}}
    <section class="profile">
        <div class="profile__left">
            <div class="profile__avatar"></div>
        </div>

        <div class="profile__right">
            <h2 class="profile__name">
                {{ $profile->nickname ?? '未設定' }}
            </h2>

            {{-- 住所 --}}
            <div class="profile__address">
                <p>
                    〒 {{ optional($user->address)->postal_code ?? '未設定' }}
                </p>
                <p>
                    {{ optional($user->address)->address }}
                    {{ optional($user->address)->building }}
                </p>
            </div>

            <a href="{{ route('profile.edit') }}" class="profile__edit">
                プロフィール編集
            </a>
        </div>
    </section>

    {{-- タブ --}}
    <nav class="tabs">
        <a href="{{ route('mypage.index', ['page' => 'buy']) }}"
           class="tabs__item {{ $page === 'buy' ? 'is-active' : '' }}">
            購入した商品
        </a>

        <a href="{{ route('mypage.index', ['page' => 'sell']) }}"
           class="tabs__item {{ $page === 'sell' ? 'is-active' : '' }}">
            出品した商品
        </a>

        <a href="{{ route('mypage.index', ['page' => 'favorite']) }}"
           class="tabs__item {{ $page === 'favorite' ? 'is-active' : '' }}">
            お気に入り
        </a>
    </nav>

    {{-- 商品一覧 --}}
    <section class="items">
        @if ($items->isEmpty())
            <p class="items__empty">商品はありません。</p>
        @else
            <div class="items__grid">
                @foreach ($items as $item)
                    <div class="item-card">
                        <div class="item-card__image">
                            <img src="{{ $item->image }}" alt="{{ $item->title }}">
                        </div>
                        <p class="item-card__title">
                            {{ $item->title }}
                        </p>
                    </div>
                @endforeach
            </div>
        @endif
    </section>

</div>
@endsection
