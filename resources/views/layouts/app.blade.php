<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'COACHTECH')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

<header class="header">
    <div class="header-inner">
        <div class="header-left">
            <span class="logo">COACHTECH</span>
        </div>

        <div class="header-center">
            <input
                type="text"
                class="search-input"
                placeholder="なにをお探しですか？"
            >
        </div>

        <nav class="header-right">
            @auth
                {{-- 出品 --}}
                <a href="{{ route('items.create') }}" class="sell-btn">出品</a>

                {{-- マイページ --}}
                <a href="{{ route('mypage.index') }}">マイページ</a>

                {{-- ログアウト（POST必須） --}}
                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button type="submit" class="logout-btn">ログアウト</button>
                </form>
            @else
                <a href="{{ route('login') }}">ログイン</a>
                <a href="{{ route('register') }}">登録</a>
            @endauth
        </nav>
    </div>
</header>

<main class="main">
    @yield('content')
</main>

</body>
</html>
