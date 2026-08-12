@extends('main', ['theme' => 'checkout'])

@section('title')
    {{ $confirmed ? 'Booking confirmed' : 'Payment verification' }}
@endsection

@section('content')
    <section class="checkout">
        <div class="checkout__confirm">
            <p class="checkout__head">{{ $confirmed ? 'Thank you!' : 'Booking requires attention' }}</p>
            <p>{{ $message }}</p>
            @if($confirmed && isset($order))
                <p>Order #{{ $order->id }}</p>
            @endif
            <a class="button button--fill" href="/">Back to tours</a>
        </div>
    </section>
@endsection
