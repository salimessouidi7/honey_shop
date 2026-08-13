@extends('admin.layout')

@section('title', __('Products'))

@section('content')

{{-- Page Header --}}
<div class="d-flex justify-content-between align-items-center mb-3">

    <div>
        <h2 class="fw-bold mb-1">
            {{ __('Products') }}
        </h2>

        <p class="text-muted mb-0">
            {{ __('Manage your honey products.') }}
        </p>
    </div>

    <a href="{{ route('admin.products.create') }}"
       class="btn btn-primary">
        + {{ __('Add Product') }}
    </a>

</div>


{{-- Products Table --}}
<div class="card border-0 shadow-sm">

    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">

                    <tr>
                        <th class="px-4">{{ __('Product') }}</th>
                        <th>{{ __('Catalog') }}</th>
                        <th>{{ __('Price') }}</th>
                        <th>{{ __('Stock') }}</th>
                        <th class="text-end px-4">{{ __('Actions') }}</th>
                    </tr>

                </thead>


                <tbody>

                    @forelse ($products as $product)

                        <tr>

                            {{-- Product --}}
                            <td class="px-4">

                                <div class="d-flex align-items-center">

                                    <img
                                        src="{{ asset($product->display_image) }}"
                                        width="50"
                                        height="50"
                                        class="rounded-3 me-3"
                                        style="object-fit: cover;"
                                        alt="{{ $product->name }}"
                                    >

                                    <div>

                                        <div class="fw-semibold">
                                            {{ $product->name }}
                                        </div>

                                        @if ($product->honey_type)
                                            <small class="text-muted">
                                                {{ $product->honey_type }}
                                            </small>
                                        @endif

                                    </div>

                                </div>

                            </td>


                            {{-- Catalog --}}
                            <td>

                                @if ($product->catalog)

                                    <span class="badge bg-light text-dark border">
                                        🍯 {{ $product->catalog->name }}
                                    </span>

                                @else

                                    <span class="text-muted">
                                        —
                                    </span>

                                @endif

                            </td>


                            {{-- Price --}}
                            <td>

                                @if ($product->has_discount)

                                    <div class="d-flex align-items-center gap-2">
                                        <div>
                                            <span class="text-muted text-decoration-line-through small d-block">
                                                ${{ number_format($product->price, 2) }}
                                            </span>
                                            <span class="fw-semibold text-danger">
                                                ${{ number_format($product->final_price, 2) }}
                                            </span>
                                        </div>
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle">
                                            {{ $product->discount_label }}
                                        </span>
                                    </div>

                                @else

                                    <span class="fw-semibold">
                                        ${{ number_format($product->price, 2) }}
                                    </span>

                                @endif

                            </td>


                            {{-- Stock --}}
                            <td>

                                @if ($product->stock > 0)

                                    <span class="badge bg-light text-dark border">
                                        {{ trans_choice('{1} :count unit|[2,*] :count units', $product->stock, ['count' => $product->stock]) }}
                                    </span>

                                @else

                                    <span class="badge bg-danger">
                                        {{ __('Out of stock') }}
                                    </span>

                                @endif

                            </td>


                            {{-- Actions --}}
                            <td class="text-end px-4">

                                {{-- Edit --}}
                                <a
                                    href="{{ route('admin.products.edit', $product) }}"
                                    class="btn btn-outline-primary btn-sm"
                                >
                                    {{ __('Edit') }}
                                </a>


                                {{-- Delete --}}
                                @if (auth()->user()->role === 'admin')

                                    <button
                                        type="button"
                                        class="btn btn-danger btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteProductModal{{ $product->id }}"
                                    >
                                        {{ __('Delete') }}
                                    </button>


                                    {{-- Delete Confirmation Modal --}}
                                    <div
                                        class="modal fade"
                                        id="deleteProductModal{{ $product->id }}"
                                        tabindex="-1"
                                        aria-labelledby="deleteProductModalLabel{{ $product->id }}"
                                        aria-hidden="true"
                                    >

                                        <div class="modal-dialog modal-dialog-centered">

                                            <div class="modal-content">

                                                {{-- Modal Header --}}
                                                <div class="modal-header">

                                                    <h5
                                                        class="modal-title"
                                                        id="deleteProductModalLabel{{ $product->id }}"
                                                    >
                                                        {{ __('Confirm Product Deletion') }}
                                                    </h5>

                                                    <button
                                                        type="button"
                                                        class="btn-close"
                                                        data-bs-dismiss="modal"
                                                        aria-label="Close"
                                                    ></button>

                                                </div>


                                                {{-- Modal Body --}}
                                                <div class="modal-body text-start">

                                                    <p class="mb-2">

                                                        {{ __('Are you sure you want to delete') }}
                                                        <strong>{{ $product->name }}</strong>?

                                                    </p>

                                                    <div class="alert alert-danger mb-0">

                                                        <strong>⚠️ {{ __('Warning:') }}</strong>

                                                        <br>

                                                        {{ __('This product will be permanently deleted and this action cannot be undone.') }}

                                                    </div>

                                                </div>


                                                {{-- Modal Footer --}}
                                                <div class="modal-footer">

                                                    <button
                                                        type="button"
                                                        class="btn btn-secondary"
                                                        data-bs-dismiss="modal"
                                                    >
                                                        {{ __('Cancel') }}
                                                    </button>


                                                    <form
                                                        action="{{ route('admin.products.destroy', $product) }}"
                                                        method="POST"
                                                        class="d-inline"
                                                    >

                                                        @csrf
                                                        @method('DELETE')

                                                        <button
                                                            type="submit"
                                                            class="btn btn-danger"
                                                        >
                                                            {{ __('Yes, Delete Product') }}
                                                        </button>

                                                    </form>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="5" class="text-center py-5">

                                <div class="text-muted">

                                    <div style="font-size: 2.5rem;">
                                        🍯
                                    </div>

                                    <p class="mb-1 fw-semibold">
                                        {{ __('No products yet') }}
                                    </p>

                                    <small>
                                        {{ __('Add your first honey product to get started.') }}
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
    {{ $products->links() }}
</div>

@endsection
