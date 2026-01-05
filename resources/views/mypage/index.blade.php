@extends('layouts.app')

@section('title', 'マイページ')

@section('content')

<div class="mypage-wrapper">

    <div class="mypage-profile-section">

        <div>
            <div class="mypage-avatar"></div>
        </div>

        <div>
            <p class="mypage-username">
                {{ $profile->nickname ?? '未設定' }}
            </p>
        </div>

        <div style="text-align:right;">
            <a href="{{ route('profile.edit') }}" class="edit-profile-btn">
                プロフィールを編集
            </a>
        </div>

    </div>

    <div class="mypage-tabs">

        <a href="{{ route('mypage.index',['page'=>'sell']) }}"
           class="mypage-tab {{ $page==='sell' ? 'active' : '' }}">
            出品した商品
        </a>

        <a href="{{ route('mypage.index',['page'=>'buy']) }}"
           class="mypage-tab {{ $page==='buy' ? 'active' : '' }}">
            購入した商品
        </a>

    </div>

    <div class="mypage-items-grid">

        @if ($page==='sell')
            @foreach($sellItems as $item)
                <div>
                    <div class="mypage-item-image">
                        <img src="{{ $item->image }}" alt="">
                    </div>

                    <p class="mypage-item-title">
                        {{ $item->title }}
                    </p>
                </div>
            @endforeach
        @endif

        @if ($page==='buy')
            @foreach($buyItems as $item)
                <div>
                    <div class="mypage-item-image">
                        <img src="{{ $item->image }}" alt="">
                    </div>

                    <p class="mypage-item-title">
                        {{ $item->title }}
                    </p>
                </div>
            @endforeach
        @endif

    </div>

</div>

@endsection
