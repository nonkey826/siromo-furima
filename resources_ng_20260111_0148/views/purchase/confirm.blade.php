@extends('layouts.app')

@section('content')
<div class="payment-wrap">
    <div class="payment-card">
        <h2>決済画面</h2>

        <p>{{ $item->title }}</p>
        <p>¥{{ number_format($item->price) }}</p>

        <form id="payment-form">
            <div id="card-element"></div>
            <button id="submit" type="submit">
                ¥{{ number_format($item->price) }} を支払う
            </button>
        </form>
    </div>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
const stripe = Stripe(@json($stripeKey));
const elements = stripe.elements();
const card = elements.create('card');
card.mount('#card-element');

document.getElementById('payment-form').addEventListener('submit', async (e) => {
    e.preventDefault();

    const { error, paymentIntent } = await stripe.confirmCardPayment(
        @json($clientSecret),
        { payment_method: { card } }
    );

    if (error) {
        alert(error.message);
        return;
    }

    if (paymentIntent.status === 'succeeded') {
        window.location.href = @json(route('purchase.complete', $item));
    }
});
</script>
@endsection
