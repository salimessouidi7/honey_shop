@extends('admin.layout')

@section('title', __('Orders'))

@section('content')

{{-- Page Header --}}
<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h2 class="fw-bold mb-1">
            {{ __('Orders') }}
        </h2>

        <p class="text-muted mb-0">
            {{ __('Manage and track customer orders.') }}
        </p>
    </div>

</div>


{{-- Orders Table --}}
<div class="card border-0 shadow-sm">

    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">

                    <tr>
                        <th class="px-4">{{ __('Order') }}</th>
                        <th>{{ __('Customer') }}</th>
                        <th>{{ __('Email') }}</th>
                        <th>{{ __('Total') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Date') }}</th>
                        <th class="text-end px-4">{{ __('Actions') }}</th>
                    </tr>

                </thead>


                <tbody>

                    @forelse ($orders as $order)

                    <tr>

                        {{-- Order --}}
                        <td class="px-4">

                            <div class="d-flex align-items-center">

                                <div class="bg-warning bg-opacity-10 rounded-3 p-2 me-3">
                                    <span style="font-size: 1.2rem;">
                                        📦
                                    </span>
                                </div>

                                <div>

                                    <div class="fw-semibold">
                                        #{{ $order->id }}
                                    </div>

                                    <small class="text-muted">
                                        {{ trans_choice('{1} :count item|[2,*] :count items', $order->items->count(), ['count' => $order->items->count()]) }}
                                    </small>

                                </div>

                            </div>

                        </td>


                        {{-- Customer --}}
                        <td>

                            <div class="fw-semibold">
                                {{ $order->guest_name }}
                            </div>

                        </td>


                        {{-- Email --}}
                        <td>

                            <span class="text-muted">
                                {{ $order->guest_email }}
                            </span>

                        </td>


                        {{-- Total --}}
                        <td>

                            <span class="fw-semibold">
                                ${{ number_format($order->total, 2) }}
                            </span>

                        </td>


                        {{-- Status --}}
                        <td>

                            @switch($order->status)

                            @case('pending')
                            <span class="badge bg-warning text-dark">
                                {{ __('Pending') }}
                            </span>
                            @break

                            @case('paid')
                            <span class="badge bg-info text-dark">
                                {{ __('Paid') }}
                            </span>
                            @break

                            @case('shipped')
                            <span class="badge bg-primary">
                                {{ __('Shipped') }}
                            </span>
                            @break

                            @case('completed')
                            <span class="badge bg-success">
                                {{ __('Completed') }}
                            </span>
                            @break

                            @case('cancelled')
                            <span class="badge bg-danger">
                                {{ __('Cancelled') }}
                            </span>
                            @break

                            @default
                            <span class="badge bg-secondary">
                                {{ __(ucfirst($order->status)) }}
                            </span>

                            @endswitch

                        </td>


                        {{-- Date --}}
                        <td>

                            <div>
                                {{ $order->created_at->format('M d, Y') }}
                            </div>

                            <small class="text-muted">
                                {{ $order->created_at->format('H:i') }}
                            </small>

                        </td>


                        {{-- Actions --}}
                        <td class="text-end px-4">

                            <a
                                href="{{ route('admin.orders.show', $order) }}"
                                class="btn btn-outline-primary btn-sm">
                                {{ __('View Order') }}
                            </a>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="7" class="text-center py-5">

                            <div class="text-muted">

                                <div style="font-size: 2.5rem;">
                                    📦
                                </div>

                                <p class="mb-1 fw-semibold">
                                    {{ __('No orders yet') }}
                                </p>

                                <small>
                                    {{ __('Customer orders will appear here once they are placed.') }}
                                </small>

                            </div>

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>


{{-- Pagination --}}
<div class="mt-3">
    {{ $orders->links() }}
</div>

@endsection