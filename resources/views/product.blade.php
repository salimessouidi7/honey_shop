@extends('layouts.app')

@section('title', $product->name)

@section('content')

<div class="mb-4">


    <a href="{{ url()->previous() }}"
        class="text-decoration-none text-muted">
        ← {{ __('Back') }}
    </a>


</div>

<div class="card border-0 shadow-sm overflow-hidden">


    <div class="row g-0">

        {{-- Product Image --}}


            <div class="col-12 col-lg-6">
                <img
                    src="{{ asset($product->display_image) }}"
                    class="img-fluid w-100 rounded"
                    alt="{{ $product->name }}">
            </div>
 


        {{-- Product Information --}}
        <div class="col-lg-6">

            <div class="p-4 p-lg-5">

                {{-- Honey Type --}}
                @if ($product->honey_type)

                <span class="badge bg-warning text-dark px-3 py-2 mb-3">
                    🍯 {{ $product->honey_type }}
                </span>

                @endif


                {{-- Product Name --}}
                <h1 class="display-6 fw-bold mb-3">
                    {{ $product->name }}
                </h1>


                {{-- Price --}}
                <div class="mb-4">

                    @if ($product->has_discount)
                        <div class="d-flex align-items-center gap-3">
                            <span class="fs-2 fw-bold text-danger">
                                ${{ number_format($product->final_price, 2) }}
                            </span>
                            <span class="fs-5 text-muted text-decoration-line-through">
                                ${{ number_format($product->price, 2) }}
                            </span>
                            <span class="badge bg-danger">
                                {{ $product->discount_label }}
                            </span>
                        </div>
                        <small class="text-success">{{ __('You save') }} ${{ number_format($product->savings_amount, 2) }}</small>
                    @else
                        <span class="fs-2 fw-bold text-primary">
                            ${{ number_format($product->price, 2) }}
                        </span>
                    @endif

                </div>


                {{-- Description --}}
                <div class="mb-4">

                    <h5 class="fw-bold">
                        {{ __('Description') }}
                    </h5>

                    <p class="text-muted lh-lg">
                        {{ $product->description ?: __('A delicious selection of natural honey.') }}
                    </p>

                </div>


                {{-- Stock --}}
                <div class="mb-4">

                    @if ($product->stock > 0)

                    <div class="d-flex align-items-center gap-2 text-success">

                        <span class="badge bg-success">
                            ✓
                        </span>

                        <span>
                            {{ trans_choice('{1} :count unit available|[2,*] :count units available', $product->stock, ['count' => $product->stock]) }}
                        </span>

                    </div>

                    @else

                    <div class="alert alert-warning">
                        {{ __('This product is currently out of stock.') }}
                    </div>

                    @endif

                </div>


                {{-- Add To Cart --}}
                @if ($product->stock > 0)

                <form
                    action="{{ route('cart.add', $product) }}"
                    method="POST">

                    @csrf

                    <div class="mb-3">

                        <label for="quantity"
                            class="form-label fw-semibold">
                            {{ __('Quantity') }}
                        </label>

                        <div class="input-group"
                            style="max-width: 240px;">

                            <input
                                type="number"
                                id="quantity"
                                name="quantity"
                                value="{{ old('quantity', 1) }}"
                                min="1"
                                max="{{ $product->stock }}"
                                class="form-control form-control-lg @error('quantity') is-invalid @enderror"
                                required>

                            <button
                                type="submit"
                                class="btn btn-success px-4">
                                🛒 {{ __('Add to Cart') }}
                            </button>

                        </div>

                        @error('quantity')

                        <div class="text-danger small mt-2">
                            {{ $message }}
                        </div>

                        @enderror

                    </div>

                </form>

                @endif


                {{-- Product Details --}}
                <div class="border-top mt-4 pt-4">

                    <div class="row g-3">

                        <div class="col-6">

                            <small class="text-muted d-block">
                                {{ __('Product') }}
                            </small>

                            <strong>
                                #{{ $product->id }}
                            </strong>

                        </div>


                        @if ($product->catalog)

                        <div class="col-6">

                            <small class="text-muted d-block">
                                {{ __('Catalog') }}
                            </small>

                            <strong>
                                {{ $product->catalog->name }}
                            </strong>

                        </div>

                        @endif

                    </div>

                </div>

            </div>

        </div>

    </div>


</div>

@if (\App\Models\Feature::enabled('comments'))

    <div class="card border-0 shadow-sm mt-4 p-4">

        <h4 class="fw-bold mb-3">
            {{ __('Feedback') }}
            @if ($product->average_rating)
                <span class="text-warning">{{ str_repeat('★', round($product->average_rating)) }}{{ str_repeat('☆', 5 - round($product->average_rating)) }}</span>
                <span class="text-muted fs-6">({{ $product->average_rating }} / 5)</span>
            @endif
        </h4>

        @auth
            <form method="POST" action="{{ route('comments.store', $product) }}" class="mb-4">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold">{{ __('Your rating (optional)') }}</label>
                    <select name="rating" class="form-select" style="max-width: 200px;">
                        <option value="">{{ __('No rating') }}</option>
                        <option value="5" @selected(old('rating') == 5)>★★★★★ (5)</option>
                        <option value="4" @selected(old('rating') == 4)>★★★★☆ (4)</option>
                        <option value="3" @selected(old('rating') == 3)>★★★☆☆ (3)</option>
                        <option value="2" @selected(old('rating') == 2)>★★☆☆☆ (2)</option>
                        <option value="1" @selected(old('rating') == 1)>★☆☆☆☆ (1)</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">{{ __('Comment') }}</label>
                    <textarea name="body" rows="3" class="form-control @error('body') is-invalid @enderror" required>{{ old('body') }}</textarea>
                    @error('body') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <button type="submit" class="btn btn-primary">{{ __('Submit Feedback') }}</button>
            </form>
        @else
            <p class="text-muted">
                <a href="{{ route('login') }}">{{ __('Log in') }}</a> {{ __('to leave feedback on this product.') }}
            </p>
        @endauth

        <hr>

        @forelse ($product->comments as $comment)
            <div class="mb-3 pb-3 border-bottom">
                <div class="d-flex justify-content-between">
                    <strong>{{ $comment->user->name }}</strong>
                    <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                </div>
                @if ($comment->rating)
                    <span class="text-warning">{{ str_repeat('★', $comment->rating) }}{{ str_repeat('☆', 5 - $comment->rating) }}</span>
                @endif
                <p class="mb-0 mt-1">{{ $comment->body }}</p>
            </div>
        @empty
            <p class="text-muted mb-0">{{ __("No feedback yet - be the first to share your thoughts!") }}</p>
        @endforelse

    </div>

@endif

@endsection