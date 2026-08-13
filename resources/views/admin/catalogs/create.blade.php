@extends('admin.layout')

@section('title', __('Add Catalog'))

@section('content')

<div class="container-fluid">

    {{-- Page Header --}}
    <div class="mb-4">

        <h2 class="fw-bold mb-1">
            {{ __('Add Catalog') }}
        </h2>

        <p class="text-muted mb-0">
            {{ __('Create a new catalog to organize your honey products.') }}
        </p>

    </div>


    {{-- Catalog Form --}}
    <div class="card border-0 shadow-sm">

        <div class="card-body p-4">

            <form method="POST"
                  action="{{ route('admin.catalogs.store') }}">

                @csrf

                @include('admin.catalogs._form', [
                    'catalog' => null
                ])


                {{-- Form Actions --}}
                <div class="d-flex justify-content-end gap-2 mt-4 pt-4 border-top">

                    <a href="{{ route('admin.catalogs.index') }}"
                       class="btn btn-light px-4">
                        {{ __('Cancel') }}
                    </a>

                    <button type="submit"
                            class="btn btn-primary px-4">
                        🍯 {{ __('Create Catalog') }}
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection
