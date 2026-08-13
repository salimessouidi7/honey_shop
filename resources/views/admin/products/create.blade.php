@extends('admin.layout')

@section('title', __('Add Product'))

@section('content')

<div class="container-fluid">

    <div class="mb-4">
        <h2 class="fw-bold mb-1">{{ __('Add Product') }}</h2>
        <p class="text-muted mb-0">
            {{ __('Create a new honey product for your catalog.') }}
        </p>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">

            <form method="POST" action="{{ route('admin.products.store') }}">
                @csrf

                @include('admin.products._form', ['product' => null])

                <div class="d-flex justify-content-end gap-2 mt-4 pt-4 border-top">

                    <a href="{{ route('admin.products.index') }}"
                        class="btn btn-light px-4">
                        {{ __('Cancel') }}
                    </a>

                    <button type="submit" class="btn btn-primary px-4">
                        🍯 {{ __('Create Product') }}
                    </button>

                </div>

            </form>

        </div>
    </div>

</div>

@endsection