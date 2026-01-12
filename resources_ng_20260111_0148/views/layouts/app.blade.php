<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    {{-- 共通CSS --}}
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    {{-- favicon --}}
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/apple-touch-icon.png') }}">

    {{-- CSRF（JS用） --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        /* =========================
           ベース
        ========================= */
        body {
            margin: 0;
            font-family: sans-serif;
            min-height: 100vh;

            /* PC背景 */
            background-color: #fff5f7;
            background-image: url('/storage/items/bg_pinl_bone-furima.png');

            background-repeat: repeat;
            background-size: 200px 200px;
        }

        /* =========================
           ヘッダー
        ========================= */
        header {
            background: #4a342e; /* ダークブラウン */
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
            display: flex;
            align-items: center;
            gap: 8px;
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

        /* =========================
           メイン（白カード）
        ========================= */
        .main-content {
            padding: 40px;
            background: rgba(255, 255, 255, 0.92);
            border-radius: 8px;
            max-width: 1000px;
            margin: 40px auto;
        }

        /* =========================
           スマホ対応（最小・安全）
        ========================= */
        @media screen and (max-width: 768px) {

            header {
                flex-direction: column;
                align-items: stretch;
                padding: 12px 16px;
                gap: 10px;
            }

            .header-left {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .logo {
                font-size: 18px;
            }

            .search-box input {
                width: 100%;
                box-sizing: border-box;
            }

            nav {
                display: flex;
                justify-content: space-between;
                flex-wrap: wrap;
                gap: 10px;
                margin-top: 5px;
            }

            nav a {
                margin-left: 0;
                font-size: 13px;
            }

            /* スマホでは背景を静かに */
            body {
                background-color: #fff5f7;
                background-image: none;
            }

            .main-content {
                margin: 20px 0;
                padding: 20px 12px;
                border-radius: 0;
            }
        }
    </style>
</head>

<body>

<header>

    {{-- 左側 --}}
    <div class="header-left">
        <a href="{{ route('items.index') }}" class="logo">
            <img src="{{ asset('images/logo.png') }}" alt="白もふリマ" style="height:32px;">
            <span>犬用品専門フリマアプリ</span>
        </a>

        {{-- 検索窓（ログイン・登録画面以外） --}}
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

    {{-- 右側ナビ（ログイン・登録画面以外） --}}
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

<main class="main-content">
    @yield('content')
</main>

{{-- =========================
     いいね：ちょこっとJS（本番安全版）
========================= --}}
<script>
document.addEventListener('DOMContentLoaded', () => {

  /* =========================
     いいね（fetch / 安全版）
  ========================= */
  const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
  const basePath = "{{ url('/') }}";

  document.querySelectorAll('.like-btn').forEach((btn) => {
    btn.addEventListener('click', async (e) => {
      e.preventDefault();
      e.stopPropagation();

      if (!csrf) return;

      const itemId = btn.dataset.itemId;
      const liked  = btn.dataset.liked === '1';
      const countEl = btn.nextElementSibling;
      const card = btn.closest('.items-box');

      const url = `${basePath}/items/${itemId}/like`;
      const method = liked ? 'DELETE' : 'POST';

      try {
        const res = await fetch(url, {
          method,
          headers: {
            'X-CSRF-TOKEN': csrf,
            'Accept': 'application/json',
          },
        });

        if (!res.ok) return;

        // 状態更新
        btn.dataset.liked = liked ? '0' : '1';
        btn.textContent = liked ? '♡' : '♥️';
        btn.style.color = liked ? '#ccc' : '#ff5555';

        if (countEl) {
          const current = parseInt(countEl.textContent, 10) || 0;
          countEl.textContent = liked
            ? Math.max(0, current - 1)
            : current + 1;
        }

        // ボタンぽよっ
        btn.animate(
          [
            { transform: 'scale(1)' },
            { transform: 'scale(1.25)' },
            { transform: 'scale(1)' }
          ],
          { duration: 180, easing: 'ease-out' }
        );

        // カード全体も軽く反応
        card?.animate(
          [
            { transform: 'scale(1)' },
            { transform: 'scale(1.02)' },
            { transform: 'scale(1)' }
          ],
          { duration: 220, easing: 'ease-out' }
        );

      } catch (err) {
        console.error('like error:', err);
      }
    });
  });

  /* =========================
     UI演出（一覧）
  ========================= */

  // ふわっと順番表示
  document.querySelectorAll('.items-box').forEach((card, i) => {
    setTimeout(() => {
      card.classList.add('is-visible');
    }, i * 60);
  });

  // ホバー演出
  document.querySelectorAll('.items-box').forEach(card => {
    card.addEventListener('mouseenter', () => card.classList.add('is-hover'));
    card.addEventListener('mouseleave', () => card.classList.remove('is-hover'));
  });

  // タブ切替フェード
  document.querySelectorAll('a[href*="tab"]').forEach(tab => {
    tab.addEventListener('click', () => {
      document.querySelector('.items-grid')?.classList.add('is-loading');
    });
  });

  /* =========================
     ヘッダー自動表示 / 非表示
  ========================= */
  let lastScroll = 0;
  const header = document.querySelector('header');

  if (header) {
    header.style.transition = 'transform .35s ease';

    window.addEventListener('scroll', () => {
      const y = window.scrollY;
      header.style.transform =
        (y > lastScroll && y > 80)
          ? 'translateY(-100%)'
          : 'translateY(0)';
      lastScroll = y;
    });
  }

});
</script>


</body>
</html>
