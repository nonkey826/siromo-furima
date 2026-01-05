<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>@yield('title')</title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
        body {
            margin: 0;
            font-family: sans-serif;
            background: #fff;
        }

        header {
            background: #000;
            color: #fff;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .logo {
            color: #fff;
            font-weight: 900;
            font-size: 22px;
            text-decoration: none;
        }

        .search-box input {
            width: 300px;
            padding: 6px 10px;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            margin-left: 20px;
            font-size: 14px;
            font-weight: 600;
        }
    </style>
</head>

<body>

<header>

    {{-- 左側 --}}
    <div class="header-left">
        <a href="{{ route('items.index') }}" class="logo">
            COACHTECH
        </a>

        {{-- 検索窓 --}}
@unless (request()->routeIs('login', 'register'))
    <form
        action="{{ route('items.index') }}"
        method="GET"
        class="search-box"
    >
        <input
            type="text"
            name="keyword"
            placeholder="なにをお探しですか？"
            value="{{ request('keyword') }}"
        >
    </form>
@endunless

    </div>

    {{-- 右側：ログイン・会員登録画面では非表示 --}}
    @unless (request()->routeIs('login', 'register'))
        <nav>
            <a href="{{ route('items.index') }}">商品一覧</a>

            @auth
                <a href="{{ route('mypage.index') }}">マイページ</a>
                <a href="{{ route('items.create') }}">出品</a>

                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    ログアウト
                </a>

                <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display:none;">
                    @csrf
                </form>
            @endauth

            @guest
                <a href="{{ route('login') }}">ログイン</a>
                <a href="{{ route('register') }}">会員登録</a>
            @endguest
        </nav>
    @endunless

</header>

<main style="padding:40px;">
    @yield('content')
</main>

</body>
</html>
