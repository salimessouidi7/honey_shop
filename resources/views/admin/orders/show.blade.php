@extends('admin.layout')

@section('title', __('Order') . ' #' . $order->id)

@section('content')

{{-- Page Header --}}
<div class="d-flex justify-content-between align-items-center mb-4 no-print">

    <div>

        <h2 class="fw-bold mb-1">
            {{ __('Order') }} #{{ $order->id }}
        </h2>

        <p class="text-muted mb-0">
            {{ __('Placed on') }} {{ $order->created_at->format('M d, Y \a\t H:i') }}
        </p>

    </div>


    <div class="d-flex gap-2">

        <a href="{{ route('admin.orders.index') }}"
            class="btn btn-light border">
            ← {{ __('Back to Orders') }}
        </a>

        <button
            type="button"
            class="btn btn-primary"
            onclick="window.print()">
            🖨️ {{ __('Print Order') }}
        </button>

    </div>

</div>


{{-- PRINTABLE ORDER DOCUMENT --}}
<div id="print-order">


    {{-- Print Header --}}
    <div class="print-header">

        <div>

            <h1>
                {{ __('Honey Shop') }}
            </h1>

            <p>
                {{ __('Order') }} #{{ $order->id }}
            </p>

        </div>

        <div class="text-end">

            <strong>
                {{ __('ORDER') }}
            </strong>

            <br>

            {{ $order->created_at->format('M d, Y H:i') }}

        </div>

    </div>


    <div class="row g-4">

        {{-- Left Column --}}
        <div class="col-lg-8">


            {{-- Customer Information --}}
            <div class="card border-0 shadow-sm mb-4 print-card">

                <div class="card-body p-4">

                    <div class="d-flex align-items-center mb-4 no-print">

                        <div class="bg-primary bg-opacity-10 rounded-3 p-3 me-3">
                            <span style="font-size: 1.4rem;">
                                👤
                            </span>
                        </div>

                        <div>

                            <h5 class="mb-1 fw-semibold">
                                {{ __('Customer Information') }}
                            </h5>

                            <p class="text-muted mb-0 small">
                                {{ __('Contact and delivery information.') }}
                            </p>

                        </div>

                    </div>


                    <h5 class="print-section-title">
                        {{ __('Customer Information') }}
                    </h5>


                    <div class="row g-4">

                        {{-- Name --}}
                        <div class="col-md-6">

                            <label class="text-muted small d-block mb-1">
                                {{ __('Customer') }}
                            </label>

                            <div class="fw-semibold">
                                {{ $order->guest_name }}
                            </div>

                        </div>


                        {{-- Email --}}
                        <div class="col-md-6">

                            <label class="text-muted small d-block mb-1">
                                {{ __('Email') }}
                            </label>

                            <div>
                                {{ $order->guest_email }}
                            </div>

                        </div>


                        {{-- Phone --}}
                        <div class="col-md-6">

                            <label class="text-muted small d-block mb-1">
                                {{ __('Phone') }}
                            </label>

                            <div class="fw-semibold">
                                {{ $order->guest_phone ?: '—' }}
                            </div>

                        </div>


                        {{-- Address --}}
                        <div class="col-md-6">

                            <label class="text-muted small d-block mb-1">
                                {{ __('Delivery Address') }}
                            </label>

                            <div class="fw-semibold">
                                {{ $order->guest_address ?: '—' }}
                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- Order Items --}}
            <div class="card border-0 shadow-sm print-card">

                <div class="card-body p-0">

                    <div class="p-4 border-bottom no-print">

                        <div class="d-flex align-items-center">

                            <div class="bg-warning bg-opacity-10 rounded-3 p-3 me-3">

                                <span style="font-size: 1.4rem;">
                                    🛒
                                </span>

                            </div>

                            <div>

                                <h5 class="mb-1 fw-semibold">
                                    {{ __('Order Items') }}
                                </h5>

                                <p class="text-muted mb-0 small">
                                    {{ __('Products included in this order.') }}
                                </p>

                            </div>

                        </div>

                    </div>


                    <div class="p-4 print-only">

                        <h5 class="print-section-title">
                            {{ __('Order Items') }}
                        </h5>

                    </div>


                    <div class="table-responsive">

                        <table class="table table-hover align-middle mb-0">

                            <thead class="table-light">

                                <tr>

                                    <th class="px-4">
                                        {{ __('Product') }}
                                    </th>

                                    <th>
                                        {{ __('Quantity') }}
                                    </th>

                                    <th>
                                        {{ __('Price') }}
                                    </th>

                                    <th class="text-end px-4">
                                        {{ __('Subtotal') }}
                                    </th>

                                </tr>

                            </thead>


                            <tbody>

                                @foreach ($order->items as $item)

                                <tr>

                                    {{-- Product --}}
                                    <td class="px-4">

                                        <div class="d-flex align-items-center">

                                            @if ($item->product)

                                            <img
                                                src="{{ asset($item->product->display_image) }}"
                                                width="45"
                                                height="45"
                                                class="rounded-3 me-3 product-image"
                                                style="object-fit: cover;"
                                                alt="{{ $item->product->name }}">

                                            @endif


                                            <div>

                                                <div class="fw-semibold">

                                                    {{ $item->product->name ?? __('Deleted product') }}

                                                </div>

                                                @if ($item->product?->honey_type)

                                                <small class="text-muted">
                                                    {{ $item->product->honey_type }}
                                                </small>

                                                @endif

                                            </div>

                                        </div>

                                    </td>


                                    {{-- Quantity --}}
                                    <td>

                                        {{ $item->quantity }}

                                    </td>


                                    {{-- Price --}}
                                    <td>

                                        ${{ number_format($item->price, 2) }}

                                    </td>


                                    {{-- Subtotal --}}
                                    <td class="text-end px-4">

                                        <strong>
                                            ${{ number_format($item->price * $item->quantity, 2) }}
                                        </strong>

                                    </td>

                                </tr>

                                @endforeach

                            </tbody>


                            <tfoot>

                                <tr>

                                    <td colspan="3" class="text-end">

                                        <strong>
                                            {{ __('TOTAL') }}
                                        </strong>

                                    </td>

                                    <td class="text-end px-4">

                                        <strong class="fs-5">
                                            ${{ number_format($order->total, 2) }}
                                        </strong>

                                    </td>

                                </tr>

                            </tfoot>

                        </table>

                    </div>

                </div>

            </div>

        </div>


        {{-- Right Column --}}
        <div class="col-lg-4 no-print">


            {{-- Order Status --}}
            <div class="card border-0 shadow-sm mb-4">

                <div class="card-body p-4">

                    <div class="d-flex align-items-center mb-4">

                        <div class="bg-success bg-opacity-10 rounded-3 p-3 me-3">

                            <span style="font-size: 1.4rem;">
                                📋
                            </span>

                        </div>

                        <div>

                            <h5 class="mb-1 fw-semibold">
                                {{ __('Order Status') }}
                            </h5>

                            <p class="text-muted mb-0 small">
                                {{ __('Update the current order status.') }}
                            </p>

                        </div>

                    </div>


                    <form
                        action="{{ route('admin.orders.status', $order) }}"
                        method="POST">

                        @csrf
                        @method('PATCH')


                        <label class="form-label fw-semibold">
                            {{ __('Status') }}
                        </label>

                        <select
                            name="status"
                            class="form-select form-select-lg mb-3">

                            @foreach (['pending', 'paid', 'shipped', 'completed', 'cancelled'] as $status)

                            <option
                                value="{{ $status }}"
                                @selected($order->status === $status)
                                >
                                {{ __(ucfirst($status)) }}
                            </option>

                            @endforeach

                        </select>


                        <button
                            type="submit"
                            class="btn btn-primary w-100">
                            {{ __('Update Status') }}
                        </button>

                    </form>

                </div>

            </div>


            {{-- Order Summary --}}
            <div class="card border-0 shadow-sm">

                <div class="card-body p-4">

                    <h6 class="fw-semibold mb-3">
                        {{ __('Order Summary') }}
                    </h6>


                    <div class="d-flex justify-content-between py-2 border-bottom">

                        <span class="text-muted">
                            {{ __('Order ID') }}
                        </span>

                        <span class="fw-medium">
                            #{{ $order->id }}
                        </span>

                    </div>


                    <div class="d-flex justify-content-between py-2 border-bottom">

                        <span class="text-muted">
                            {{ __('Items') }}
                        </span>

                        <span class="fw-medium">
                            {{ $order->items->count() }}
                        </span>

                    </div>


                    <div class="d-flex justify-content-between py-2 border-bottom">

                        <span class="text-muted">
                            {{ __('Date') }}
                        </span>

                        <span class="fw-medium">
                            {{ $order->created_at->format('M d, Y') }}
                        </span>

                    </div>


                    <div class="d-flex justify-content-between pt-3">

                        <span class="fw-semibold">
                            {{ __('Total') }}
                        </span>

                        <span class="fw-bold fs-5">
                            ${{ number_format($order->total, 2) }}
                        </span>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


{{-- Print Styles --}}
<style>
    .print-only {
        display: none;
    }


    .print-header {
        display: none;
    }


    @media print {

        /*
         * Hide everything that isn't part
         * of the printable order.
         */
        body * {
            visibility: hidden;
        }


        #print-order,
        #print-order * {
            visibility: visible;
        }


        #print-order {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }


        /*
         * Hide admin controls.
         */
        .no-print {
            display: none !important;
        }


        /*
         * Show print-only elements.
         */
        .print-only {
            display: block !important;
        }


        /*
         * Print header.
         */
        .print-header {
            display: flex !important;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 2px solid #000;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }


        .print-header h1 {
            font-size: 24px;
            margin: 0;
        }


        .print-header p {
            margin: 4px 0 0;
        }


        /*
         * Remove Bootstrap card styling.
         */
        .print-card {
            box-shadow: none !important;
            border: 1px solid #ddd !important;
            margin-bottom: 20px !important;
        }


        /*
         * Section titles.
         */
        .print-section-title {
            display: block;
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 15px;
        }


        /*
         * Don't print product images.
         * This keeps the shipping document compact.
         */
        .product-image {
            display: none !important;
        }


        /*
         * Make sure table borders print.
         */
        table {
            border-collapse: collapse !important;
        }


        th,
        td {
            border: 1px solid #ddd !important;
        }


        /*
         * Avoid breaking cards between pages.
         */
        .print-card {
            break-inside: avoid;
            page-break-inside: avoid;
        }


        /*
         * Remove unnecessary spacing.
         */
        .row {
            --bs-gutter-x: 0;
        }


        /*
         * Printed document typography.
         */
        body {
            font-size: 12px;
        }

    }
</style>

@endsection