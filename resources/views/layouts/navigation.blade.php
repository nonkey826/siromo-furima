<nav style="background:white; border-bottom:1px solid #ddd; padding:14px 30px;">

    <div style="max-width:1200px; margin:0 auto; display:flex; justify-content:space-between; align-items:center;">

        {{-- 左ロゴ --}}
        <a href="{{ route('items.index') }}" style="font-size:22px; font-weight:700; color:#333; text-decoration:none;">
            COACHTECH フリマ
        </a>

        {{-- 右メニュー --}}
        <div style="display:flex; gap:25px; align-items:center;">

            <a href="{{ route('items.index') }}" style="text-decoration:none; color:#333;">
                商品一覧
            </a>

            <a href="{{ route('mypage.index') }}" style="text-decoration:none; color:#333;">
                マイページ
            </a>

            <a href="{{ route('items.create') }}" style="text-decoration:none; color:#333;">
                出品
            </a>

            @auth
                {{-- ドロップダウン無しの簡易 --}}
                <a href="{{ route('profile.edit') }}" style="text-decoration:none; color:#333;">
                    プロフィール
                </a>

                <a href="{{ route('address.edit') }}" style="text-decoration:none; color:#333;">
                    住所変更
                </a>

                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button style="background:none; border:none; color:#333; cursor:pointer;">
                        ログアウト
                    </button>
                </form>
            @endauth

            @guest
                <a href="/dev-login" style="text-decoration:none; color:#333;">
                    ログイン
                </a>
            @endguest

        </div>

    </div>

</nav>
