@extends('layouts.app')

@section('content')
<div class="payment-wrap">
    <div class="payment-card">
        <h2 class="payment-title">決済画面</h2>

        <div class="item-box">
            <div class="item-name">{{ $item->name }}</div>
            <div class="item-price">¥{{ number_format($item->price) }}</div>
        </div>

        <form id="payment-form">
            <label class="payment-label" for="card-element">クレジットカード</label>
            <div id="card-element" class="card-element"></div>

            <button id="submit" class="pay-btn" type="submit">
                ¥{{ number_format($item->price) }} を支払う
            </button>

            <p id="card-error" class="card-error" role="alert" style="display:none;"></p>
        </form>

        <p class="payment-note">
            ※ テスト決済です（本番の請求は発生しません）
        </p>
    </div>
</div>

<style>
.payment-wrap{
    max-width: 520px;
    margin: 40px auto;
    padding: 0 16px;
}
.payment-card{
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 10px 25px rgba(0,0,0,.08);
    padding: 24px;
}
.payment-title{
    text-align: center;
    margin: 0 0 16px;
    font-size: 18px;
}
.item-box{
    background: #f7f7f7;
    border-radius: 10px;
    padding: 16px;
    margin-bottom: 18px;
}
.item-name{
    font-weight: 700;
    font-size: 15px;
}
.item-price{
    margin-top: 6px;
    font-size: 22px;
    font-weight: 800;
}
.payment-label{
    display: block;
    font-size: 13px;
    margin: 0 0 8px;
    color: #333;
}
.card-element{
    padding: 12px;
    border: 1px solid #d0d0d0;
    border-radius: 8px;
    background: #fff;
    margin-bottom: 14px;
}
.pay-btn{
    width: 100%;
    border: none;
    border-radius: 8px;
    padding: 12px 14px;
    font-size: 15px;
    font-weight: 700;
    cursor: pointer;
    background: #635bff;
    color: #fff;
}
.pay-btn:hover{
    filter: brightness(0.95);
}
.pay-btn:disabled{
    opacity: .6;
    cursor: not-allowed;
}
.card-error{
    margin: 12px 0 0;
    color: #d93025;
    font-size: 13px;
}
.payment-note{
    margin: 14px 0 0;
    font-size: 12px;
    color: #666;
    text-align: center;
}
</style>

<script src="https://js.stripe.com/v3/"></script>
<script>
const stripe = Stripe(@json($stripeKey));

// 見た目をStripeっぽくする（最低限）
const elements = stripe.elements({
    appearance: {
        theme: 'stripe',
        variables: {
            colorPrimary: '#635bff',
            borderRadius: '8px',
            fontSizeBase: '15px',
        }
    }
});

const card = elements.create('card');
card.mount('#card-element');

const form = document.getElementById('payment-form');
const submitBtn = document.getElementById('submit');
const errorEl = document.getElementById('card-error');

const setError = (msg) => {
    if (!msg) {
        errorEl.style.display = 'none';
        errorEl.textContent = '';
        return;
    }
    errorEl.style.display = 'block';
    errorEl.textContent = msg;
};

form.addEventListener('submit', async (e) => {
    e.preventDefault();
    setError(null);

    submitBtn.disabled = true;
    submitBtn.textContent = '処理中...';

    const { error, paymentIntent } = await stripe.confirmCardPayment(
        @json($clientSecret),
        { payment_method: { card } }
    );

    if (error) {
        setError(error.message);
        submitBtn.disabled = false;
        submitBtn.textContent = '¥{{ number_format($item->price) }} を支払う';
        return;
    }

    // 成功時のみ遷移
    if (paymentIntent && paymentIntent.status === 'succeeded') {
        window.location.href = @json(route('purchase.complete', $item));
        return;
    }

    // それ以外（例: requires_action 等）
    setError('決済が完了していません。もう一度お試しください。');
    submitBtn.disabled = false;
    submitBtn.textContent = '¥{{ number_format($item->price) }} を支払う';
});
</script>
@endsection

