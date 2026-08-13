@extends('admin.layout')

@section('title', __('Dashboard'))

@section('content')

<div class="container-fluid">


{{-- ========================================================= --}}
{{-- Welcome Header --}}
{{-- ========================================================= --}}

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h2 class="fw-bold mb-1">
            {{ __('Welcome back,') }} {{ auth()->user()->name }} 👋
        </h2>

        <p class="text-muted mb-0">
            {{ __("Here's what's happening with your honey shop today.") }}
        </p>

    </div>


    <div class="d-flex gap-2">

        <a
            href="{{ route('admin.products.create') }}"
            class="btn btn-primary"
        >
            + {{ __('Add Product') }}
        </a>

        <a
            href="{{ route('admin.catalogs.create') }}"
            class="btn btn-light border"
        >
            + {{ __('Add Catalog') }}
        </a>

    </div>

</div>



{{-- ========================================================= --}}
{{-- Statistics --}}
{{-- ========================================================= --}}

<div class="row g-4 mb-4">


    {{-- Products --}}
    <div class="col-xl-4 col-md-6">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body p-4">

                <div class="d-flex justify-content-between align-items-start">

                    <div>

                        <p class="text-muted mb-2">
                            {{ __('Products') }}
                        </p>

                        <h2 class="fw-bold mb-0">
                            {{ $stats['products'] }}
                        </h2>

                        <small class="text-muted">
                            {{ __('Products in your shop') }}
                        </small>

                    </div>


                    <div class="bg-warning bg-opacity-10 rounded-3 p-3">

                        <span style="font-size: 1.5rem;">
                            🍯
                        </span>

                    </div>

                </div>

            </div>

        </div>

    </div>



    {{-- Catalogs --}}
    <div class="col-xl-4 col-md-6">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body p-4">

                <div class="d-flex justify-content-between align-items-start">

                    <div>

                        <p class="text-muted mb-2">
                            {{ __('Catalogs') }}
                        </p>

                        <h2 class="fw-bold mb-0">
                            {{ $stats['catalogs'] }}
                        </h2>

                        <small class="text-muted">
                            {{ __('Product catalogs') }}
                        </small>

                    </div>


                    <div class="bg-primary bg-opacity-10 rounded-3 p-3">

                        <span style="font-size: 1.5rem;">
                            🗂️
                        </span>

                    </div>

                </div>

            </div>

        </div>

    </div>



    {{-- Orders --}}
    <div class="col-xl-4 col-md-6">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body p-4">

                <div class="d-flex justify-content-between align-items-start">

                    <div>

                        <p class="text-muted mb-2">
                            {{ __('Orders') }}
                        </p>

                        <h2 class="fw-bold mb-0">
                            {{ $stats['orders'] }}
                        </h2>

                        <small class="text-muted">
                            {{ __('Total orders') }}
                        </small>

                    </div>


                    <div class="bg-success bg-opacity-10 rounded-3 p-3">

                        <span style="font-size: 1.5rem;">
                            📦
                        </span>

                    </div>

                </div>

            </div>

        </div>

    </div>



    {{-- Pending Orders --}}
    <div class="col-xl-4 col-md-6">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body p-4">

                <div class="d-flex justify-content-between align-items-start">

                    <div>

                        <p class="text-muted mb-2">
                            {{ __('Pending Orders') }}
                        </p>

                        <h2 class="fw-bold mb-0">
                            {{ $stats['pending_orders'] }}
                        </h2>

                        <small class="text-muted">
                            {{ __('Waiting for processing') }}
                        </small>

                    </div>


                    <div class="bg-warning bg-opacity-10 rounded-3 p-3">

                        <span style="font-size: 1.5rem;">
                            ⏳
                        </span>

                    </div>

                </div>

            </div>

        </div>

    </div>



    {{-- Revenue --}}
    <div class="col-xl-4 col-md-6">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body p-4">

                <div class="d-flex justify-content-between align-items-start">

                    <div>

                        <p class="text-muted mb-2">
                            {{ __('Revenue') }}
                        </p>

                        <h2 class="fw-bold mb-0">
                            ${{ number_format($stats['revenue'], 2) }}
                        </h2>

                        <small class="text-muted">
                            {{ __('Total shop revenue') }}
                        </small>

                    </div>


                    <div class="bg-success bg-opacity-10 rounded-3 p-3">

                        <span style="font-size: 1.5rem;">
                            💰
                        </span>

                    </div>

                </div>

            </div>

        </div>

    </div>



    {{-- Admin Users --}}
    <div class="col-xl-4 col-md-6">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body p-4">

                <div class="d-flex justify-content-between align-items-start">

                    <div>

                        <p class="text-muted mb-2">
                            {{ __('Admin Users') }}
                        </p>

                        <h2 class="fw-bold mb-0">
                            {{ $stats['admins'] }}
                        </h2>

                        <small class="text-muted">
                            {{ __('Administrators and staff') }}
                        </small>

                    </div>


                    <div class="bg-primary bg-opacity-10 rounded-3 p-3">

                        <span style="font-size: 1.5rem;">
                            👤
                        </span>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>



{{-- ========================================================= --}}
{{-- Recent Orders --}}
{{-- ========================================================= --}}

<div class="card border-0 shadow-sm">


    {{-- Card Header --}}
    <div class="card-body p-4 border-bottom">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

            <div>

                <h5 class="fw-semibold mb-1">

                    @if ($status)

                        {{ __(ucfirst($status)) }} {{ __('Orders') }}

                    @else

                        {{ __('Recent Orders') }}

                    @endif

                </h5>


                <p class="text-muted mb-0 small">
                    {{ __('The latest orders placed by your customers.') }}
                </p>

            </div>


            <a
                href="{{ route('admin.orders.index') }}"
                class="btn btn-outline-primary btn-sm"
            >
                {{ __('View All Orders') }}
            </a>

        </div>



        {{-- ================================================= --}}
        {{-- Status Filters --}}
        {{-- ================================================= --}}

        <div class="mt-4">

            <div class="d-flex align-items-center flex-wrap gap-2">

                <span class="text-muted small fw-semibold me-1">
                    {{ __('Filter:') }}
                </span>


                {{-- All --}}
                <a
                    href="{{ route('admin.dashboard') }}"
                    class="btn btn-sm {{ !$status ? 'btn-primary' : 'btn-light border' }}"
                >
                    {{ __('All') }}
                </a>


                {{-- Pending --}}
                <a
                    href="{{ route('admin.dashboard', ['status' => 'pending']) }}"
                    class="btn btn-sm {{ $status === 'pending' ? 'btn-warning' : 'btn-light border' }}"
                >
                    ⏳ {{ __('Pending') }}
                </a>


                {{-- Paid --}}
                <a
                    href="{{ route('admin.dashboard', ['status' => 'paid']) }}"
                    class="btn btn-sm {{ $status === 'paid' ? 'btn-info' : 'btn-light border' }}"
                >
                    💳 {{ __('Paid') }}
                </a>


                {{-- Shipped --}}
                <a
                    href="{{ route('admin.dashboard', ['status' => 'shipped']) }}"
                    class="btn btn-sm {{ $status === 'shipped' ? 'btn-primary' : 'btn-light border' }}"
                >
                    🚚 {{ __('Shipped') }}
                </a>


                {{-- Completed --}}
                <a
                    href="{{ route('admin.dashboard', ['status' => 'completed']) }}"
                    class="btn btn-sm {{ $status === 'completed' ? 'btn-success' : 'btn-light border' }}"
                >
                    ✓ {{ __('Completed') }}
                </a>


                {{-- Cancelled --}}
                <a
                    href="{{ route('admin.dashboard', ['status' => 'cancelled']) }}"
                    class="btn btn-sm {{ $status === 'cancelled' ? 'btn-danger' : 'btn-light border' }}"
                >
                    ✕ {{ __('Cancelled') }}
                </a>

            </div>

        </div>

    </div>



    {{-- ================================================= --}}
    {{-- Orders Table --}}
    {{-- ================================================= --}}

    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">

                    <tr>

                        <th class="px-4">
                            #
                        </th>

                        <th>
                            {{ __('Customer') }}
                        </th>

                        <th>
                            {{ __('Total') }}
                        </th>

                        <th>
                            {{ __('Status') }}
                        </th>

                        <th>
                            {{ __('Date') }}
                        </th>

                        <th class="text-end px-4">
                            {{ __('Actions') }}
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse ($recentOrders as $order)

                        <tr>


                            {{-- Order ID --}}
                            <td class="px-4">

                                <span class="fw-semibold">
                                    #{{ $order->id }}
                                </span>

                            </td>


                            {{-- Customer --}}
                            <td>

                                <div class="d-flex align-items-center">

                                    <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">

                                        <span>
                                            👤
                                        </span>

                                    </div>


                                    <div>

                                        <div class="fw-semibold">
                                            {{ $order->guest_name }}
                                        </div>

                                        <small class="text-muted">
                                            {{ $order->guest_email }}
                                        </small>

                                    </div>

                                </div>

                            </td>


                            {{-- Total --}}
                            <td>

                                <span class="fw-semibold">
                                    ${{ number_format($order->total, 2) }}
                                </span>

                            </td>


                            {{-- Status --}}
                            <td>

                                @php

                                    $statusClasses = [
                                        'pending' => 'bg-warning text-dark',
                                        'paid' => 'bg-info text-dark',
                                        'shipped' => 'bg-primary',
                                        'completed' => 'bg-success',
                                        'cancelled' => 'bg-danger',
                                    ];

                                @endphp


                                <span
                                    class="badge {{ $statusClasses[$order->status] ?? 'bg-secondary' }}"
                                >
                                    {{ __(ucfirst($order->status)) }}
                                </span>

                            </td>


                            {{-- Date --}}
                            <td>

                                <span class="text-muted">
                                    {{ $order->created_at->format('M d, Y') }}
                                </span>

                            </td>


                            {{-- Actions --}}
                            <td class="text-end px-4">

                                <a
                                    href="{{ route('admin.orders.show', $order) }}"
                                    class="btn btn-outline-primary btn-sm"
                                >
                                    {{ __('View') }}
                                </a>

                            </td>

                        </tr>


                    @empty

                        <tr>

                            <td
                                colspan="6"
                                class="text-center py-5"
                            >

                                <div class="text-muted">

                                    <div style="font-size: 2.5rem;">
                                        📦
                                    </div>


                                    <p class="mb-1 fw-semibold">

                                        @if ($status)

                                            {{ __('No :status orders', ['status' => __(ucfirst($status))]) }}

                                        @else

                                            {{ __('No orders yet') }}

                                        @endif

                                    </p>


                                    <small>

                                        @if ($status)

                                            {{ __('There are currently no orders with this status.') }}

                                        @else

                                            {{ __('Orders placed by customers will appear here.') }}

                                        @endif

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


</div>

@endsection
