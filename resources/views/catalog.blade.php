@extends('layouts.app')

@section('title', $catalog->name)

@section('content')

{{-- Catalog Header --}}

<div class="p-4 p-md-5 mb-5 rounded-4"
    style="background: linear-gradient(135deg, #fff8e1, #fff3cd);">


    <div class="text-center">

        <div style="font-size: 3rem;">
            🍯
        </div>

        <h1 class="fw-bold mt-2 mb-2">
            {{ $catalog->name }}
        </h1>

        <p class="lead text-muted mb-0">
            {{ $catalog->description ?: __('Explore our selection of natural honey.') }}
        </p>

    </div>


</div>

@if ($products->isNotEmpty())


<div class="d-flex justify-content-between align-items-end mb-4">

    <div>
        <h2 class="fw-bold mb-1">
            {{ __('Our Products') }}
        </h2>

        <p class="text-muted mb-0">
            {{ trans_choice('{1} :count product available|[2,*] :count products available', $products->count(), ['count' => $products->count()]) }}
        </p>
    </div>

</div>


<div class="row g-4">

    @foreach ($products as $product)

    <div class="col-md-6 col-lg-4">

        <div class="card h-100 border-0 shadow-sm overflow-hidden">

            <div style="height: 240px; overflow: hidden; position: relative;">

                <img
                    src="{{ asset($product->display_image) }}"
                    class="w-100 h-100"
                    style="object-fit: cover;"
                    alt="{{ $product->name }}">

                @if ($product->has_discount)
                    <span class="badge bg-danger position-absolute top-0 start-0 m-3">
                        {{ $product->discount_label }}
                    </span>
                @endif

            </div>


            <div class="card-body p-4">

                <div class="d-flex justify-content-between align-items-start">

                    <div>

                        <h5 class="fw-bold mb-1">
                            {{ $product->name }}
                        </h5>

                        @if ($product->honey_type)

                        <small class="text-muted">
                            {{ $product->honey_type }}
                        </small>

                        @endif

                    </div>


                    @if ($product->stock > 0)

                    <span class="badge bg-success-subtle text-success">
                        {{ __('In Stock') }}
                    </span>

                    @else

                    <span class="badge bg-danger-subtle text-danger">
                        {{ __('Out of Stock') }}
                    </span>

                    @endif

                </div>


                <p class="text-muted mt-3 mb-3">
                    {{ Str::limit($product->description, 100) }}
                </p>


                <div class="d-flex justify-content-between align-items-center">

                    @if ($product->has_discount)
                        <span>
                            <span class="text-muted text-decoration-line-through small d-block">
                                ${{ number_format($product->price, 2) }}
                            </span>
                            <span class="fw-bold fs-5 text-danger">
                                ${{ number_format($product->final_price, 2) }}
                            </span>
                        </span>
                    @else
                        <span class="fw-bold fs-5">
                            ${{ number_format($product->price, 2) }}
                        </span>
                    @endif

                    <a href="{{ route('product.show', $product) }}"
                        class="btn btn-primary">
                        {{ __('View Details') }}
                    </a>

                </div>

            </div>

        </div>

    </div>

    @endforeach

</div>


@else


<div class="text-center py-5">

    <div style="font-size: 3rem;">
        🍯
    </div>

    <h4 class="fw-bold mt-3">
        {{ __('No products available') }}
    </h4>

    <p class="text-muted">
        {{ __('There are currently no products in this catalog.') }}
    </p>

</div>


@endif

<div class="mt-5">


    <a href="{{ route('home') }}"
        class="btn btn-outline-secondary">
        ← {{ __('Back to All Products') }}
    </a>


</div>

@endsection