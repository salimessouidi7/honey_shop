@extends('layouts.app')

@section('title', 'Order #' . $order->id)

@section('content')

    <a href="{{ route('orders.history') }}" class="btn btn-outline-secondary btn-sm mb-3">&larr; Back to My Orders</a>

    <div class="card mb-4">
        <h2>Order #{{ $order->id }}</h2>
        <p class="mb-1"><strong>Status:</strong> <span class="status {{ $order->status }}">{{ ucfirst($order->status) }}</span></p>
        <p class="mb-1"><strong>Placed:</strong> {{ $order->created_at->format('M d, Y H:i') }}</p>
        <p class="mb-0"><strong>Shipping to:</strong> {{ $order->guest_address }}</p>
    </div>

    <div class="card">
        <h2>Items</h2>
        <table class="table">
            <thead>
                <tr><th>Product</th><th>Qty</th><th>Price</th><th>Subtotal</th></tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                    <tr>
                        <td>{{ $item->product->name ?? 'Product no longer available' }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>${{ number_format($item->price, 2) }}</td>
                        <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-end">Subtotal</td>
                    <td>${{ number_format($order->subtotal, 2) }}</td>
                </tr>
                @if ($order->discount_percent > 0)
                    <tr>
                        <td colspan="3" class="text-end">Loyalty discount ({{ $order->discount_percent }}%)</td>
                        <td>-${{ number_format($order->discount_amount, 2) }}</td>
                    </tr>
                @endif
                <tr>
                    <td colspan="3" class="text-end"><strong>Total</strong></td>
                    <td><strong>${{ number_format($order->total, 2) }}</strong></td>
                </tr>
            </tfoot>
        </table>
    </div>

@endsection
