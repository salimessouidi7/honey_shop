@extends('layouts.app')

@section('title', __('Checkout'))

@section('content')

    <h1>{{ __('Checkout') }}</h1>

    @guest
        <div class="alert alert-info">
            <a href="{{ route('login') }}">{{ __('Log in') }}</a> {{ __('or') }} <a href="{{ route('register') }}">{{ __('create an account') }}</a>
            {{ __('to track this order and start earning loyalty discounts on future purchases.') }}
        </div>
    @endguest

    <div class="card mb-4" style="max-width: 500px;">
        <table class="table mb-0">
            <tbody>
                <tr>
                    <td>{{ __('Subtotal') }}</td>
                    <td class="text-end">${{ number_format($subtotal, 2) }}</td>
                </tr>
                @if ($discountPercent > 0)
                    <tr>
                        <td>{{ __('Loyalty discount') }} ({{ $discountPercent }}%) 🎉</td>
                        <td class="text-end text-success">-${{ number_format($discountAmount, 2) }}</td>
                    </tr>
                @endif
                <tr>
                    <td><strong>{{ __('Total') }}</strong></td>
                    <td class="text-end"><strong>${{ number_format($total, 2) }}</strong></td>
                </tr>
            </tbody>
        </table>
    </div>

    <form method="POST" action="{{ route('checkout.store') }}" class="mt-4" style="max-width: 500px;">
        @csrf

        <div class="mb-3">
            <label class="form-label">{{ __('Full Name') }}</label>
            <input type="text" name="guest_name" value="{{ old('guest_name', auth()->user()->name ?? '') }}"
                   class="form-control @error('guest_name') is-invalid @enderror" required>
            @error('guest_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">{{ __('Email Address') }}</label>
            <input type="email" name="guest_email" value="{{ old('guest_email', auth()->user()->email ?? '') }}"
                   class="form-control @error('guest_email') is-invalid @enderror" required>
            @error('guest_email') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">{{ __('Phone Number (optional)') }}</label>
            <input type="text" name="guest_phone" value="{{ old('guest_phone') }}"
                   class="form-control @error('guest_phone') is-invalid @enderror">
            @error('guest_phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">{{ __('Delivery Address') }}</label>
            <textarea name="guest_address" rows="3"
                      class="form-control @error('guest_address') is-invalid @enderror" required>{{ old('guest_address') }}</textarea>
            @error('guest_address') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <p class="text-muted">{{ __('This is a simulation. In production, integrate Stripe/PayPal here.') }}</p>

        <button type="submit" class="btn btn-success btn-lg">{{ __('Place Order') }}</button>
    </form>

@endsection
