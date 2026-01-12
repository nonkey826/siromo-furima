<!-- resources/views/purchase/payment.blade.php -->

<h1>支払い方法の選択</h1>

<form action="{{ route('purchase.confirm', $item) }}" method="POST">
    @csrf

    <label>
        <input type="radio" name="payment_method" value="credit" required>
        クレジットカード
    </label><br>

    <label>
        <input type="radio" name="payment_method" value="bank">
        銀行振込
    </label><br>

    <label>
        <input type="radio" name="payment_method" value="convenience">
        コンビニ払い
    </label><br><br>

    <button type="submit">確認画面へ</button>
</form>
