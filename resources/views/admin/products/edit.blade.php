@extends('admin.layout')

@section('title', __('Edit Product'))

@section('content')

<div class="container-fluid">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                {{ __('Edit Product') }}
            </h2>

            <p class="text-muted mb-0">
                {{ __('Update the information for') }}
                <strong>{{ $product->name }}</strong>.
            </p>
        </div>

        <a href="{{ route('admin.products.index') }}"
           class="btn btn-light border">
            ← {{ __('Back to Products') }}
        </a>

    </div>


    {{-- Product Form --}}
    <div class="card border-0 shadow-sm">

        <div class="card-body p-4">

            <form method="POST"
                  action="{{ route('admin.products.update', $product) }}">

                @csrf
                @method('PUT')

                {{-- Reusable Product Form --}}
                @include('admin.products._form')


                {{-- Form Actions --}}
                <div class="d-flex justify-content-end gap-2 mt-4 pt-4 border-top">

                    <a href="{{ route('admin.products.index') }}"
                       class="btn btn-light px-4">
                        {{ __('Cancel') }}
                    </a>

                    <button type="submit"
                            class="btn btn-primary px-4">
                        💾 {{ __('Update Product') }}
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>
@endsection
