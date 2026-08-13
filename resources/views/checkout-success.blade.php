@extends('layouts.app')

@section('title', __('Order Confirmed'))

@section('content')

    <div class="alert alert-success">{{ __('Order placed successfully! (Payment integration pending)') }}</div>

    <div class="card p-4" style="max-width: 500px;">
        <h4>{{ __('Order') }} #{{ $order->id }}</h4>
        <p class="mb-1"><strong>{{ __('Name') }}:</strong> {{ $order->guest_name }}</p>
        <p class="mb-1"><strong>{{ __('Email') }}:</strong> {{ $order->guest_email }}</p>
        <p class="mb-1"><strong>{{ __('Address') }}:</strong> {{ $order->guest_address }}</p>
        <hr>
        <p class="mb-1">{{ __('Subtotal') }}: ${{ number_format($order->subtotal, 2) }}</p>
        @if ($order->discount_percent > 0)
            <p class="mb-1 text-success">{{ __('Loyalty discount') }} ({{ $order->discount_percent }}%): -${{ number_format($order->discount_amount, 2) }}</p>
        @endif
        <p class="mb-1"><strong>{{ __('Total') }}:</strong> ${{ number_format($order->total, 2) }}</p>
        <p class="mb-0"><strong>{{ __('Status') }}:</strong> {{ __(ucfirst($order->status)) }}</p>
    </div>

    @guest
        <div class="alert alert-info mt-3" style="max-width: 500px;">
            <a href="{{ route('register') }}">{{ __('Create an account') }}</a> {{ __('to track this order and earn loyalty discounts next time.') }}
        </div>
    @endguest

    <a href="{{ route('home') }}" class="btn btn-primary mt-4">{{ __('Continue Shopping') }}</a>

@endsection
