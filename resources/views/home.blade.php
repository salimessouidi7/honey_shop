@extends('layouts.app')

@section('title', __('Home'))

@section('content')

{{-- Hero Section --}}

<div class="p-5 mb-5 rounded-4 shadow-sm"
    style="background: linear-gradient(135deg, #fff8e1, #fff3cd);">


    <div class="row align-items-center">

        <div class="col-lg-7">

            <span class="badge bg-warning text-dark mb-3 px-3 py-2">
                🍯 {{ __('Pure & Natural Honey') }}
            </span>

            <h1 class="display-4 fw-bold mb-3">
                {{ __('Discover the Sweetness of Nature') }}
            </h1>

            <p class="lead text-muted mb-4">
                {{ __('Explore our collection of pure honey from different bee varieties and discover your new favorite flavor.') }}
            </p>

            <a href="#featured-products"
                class="btn btn-primary btn-lg px-4">
                🛒 {{ __('Shop Now') }}
            </a>

        </div>

        <div class="col-lg-5 text-center mt-4 mt-lg-0">

            <div style="font-size: 9rem; line-height: 1;">
                🍯
            </div>

        </div>

    </div>


</div>

{{-- Catalogs --}}
@if ($catalogs->isNotEmpty())

<div class="mb-5">


    <div class="d-flex justify-content-between align-items-end mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                {{ __('Browse Our Catalogs') }}
            </h2>

            <p class="text-muted mb-0">
                {{ __('Find the perfect honey for every taste.') }}
            </p>
        </div>

    </div>


    <div class="row g-4">

        @foreach ($catalogs as $catalog)

        <div class="col-md-6 col-lg-4">

            <div class="card h-100 border-0 shadow-sm">

                <div class="card-body p-4 text-center">

                    <div class="bg-warning bg-opacity-10 rounded-circle
                            d-inline-flex align-items-center justify-content-center
                            mb-3"
                        style="width: 70px; height: 70px;">

                        <span style="font-size: 2rem;">
                            🍯
                        </span>

                    </div>

                    <h5 class="fw-bold mb-2">
                        {{ $catalog->name }}
                    </h5>

                    <p class="text-muted mb-4">
                        {{ $catalog->description ?: __('Explore our products in this category.') }}
                    </p>

                    <a href="{{ route('catalog.show', $catalog) }}"
                        class="btn btn-outline-primary">
                        {{ __('View Products') }} →
                    </a>

                </div>

            </div>

        </div>

        @endforeach

    </div>


</div>

@endif

{{-- Featured Products --}}

<div id="featured-products">


    <div class="d-flex justify-content-between align-items-end mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                {{ __('Featured Products') }}
            </h2>

            <p class="text-muted mb-0">
                {{ __('Our selection of delicious natural honey.') }}
            </p>
        </div>

    </div>


    <div class="row g-4">

        @forelse ($products as $product)

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

                    <div class="d-flex justify-content-between align-items-start mb-2">

                        <h5 class="card-title fw-bold mb-0">
                            {{ $product->name }}
                        </h5>

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


                    @if ($product->honey_type)

                    <small class="text-muted">
                        {{ $product->honey_type }}
                    </small>

                    @endif


                    <p class="card-text text-muted mt-3">
                        {{ Str::limit($product->description, 100) }}
                    </p>


                    <div class="d-flex justify-content-between align-items-center mt-4">

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

        @empty

        <div class="col-12">

            <div class="alert alert-info text-center">
                {{ __('No products available at the moment.') }}
            </div>

        </div>

        @endforelse

    </div>


</div>

@endsection