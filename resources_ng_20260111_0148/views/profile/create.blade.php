<h1>プロフィール設定</h1>

<form action="{{ route('profile.store') }}" method="POST">
    @csrf

    <label>ニックネーム</label><br>
    <input type="text" name="nickname" required>
    <br><br>

    <button type="submit">保存</button>
</form>
