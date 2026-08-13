@extends('layouts.app')

@section('title', 'My Orders')

@section('content')

    <h1 class="mb-3">My Orders</h1>

    @php $discount = auth()->user()->loyaltyDiscountPercent(); @endphp

    <div class="loyalty-banner mb-4">
        @if ($discount > 0)
            🎉 You're a loyal customer! You currently get <strong>{{ $discount }}% off</strong> every order.
        @else
            Place {{ 3 - auth()->user()->completedOrdersCount() }} more completed order(s) to unlock a 5% loyalty discount.
        @endif
    </div>

    @if ($orders->isEmpty())
        <div class="alert alert-info">You haven't placed any orders yet.</div>
        <a href="{{ route('home') }}" class="btn btn-primary">Start Shopping</a>
    @else
        <div class="card">
            <table class="table">
                <thead>
                    <tr><th>#</th><th>Date</th><th>Total</th><th>Status</th><th></th></tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>{{ $order->created_at->format('M d, Y') }}</td>
                            <td>${{ number_format($order->total, 2) }}</td>
                            <td><span class="status {{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                            <td><a href="{{ route('orders.history.show', $order) }}" class="btn btn-outline-primary btn-sm">View</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

@endsection
