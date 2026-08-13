@extends('admin.layout')

@section('title', __('Catalogs'))

@section('content')

{{-- Page Header --}}
<div class="d-flex justify-content-between align-items-center mb-3">

    <div>
        <h2 class="fw-bold mb-1">{{ __('Catalogs') }}</h2>
        <p class="text-muted mb-0">
            {{ __('Manage your honey product catalogs.') }}
        </p>
    </div>

    <a href="{{ route('admin.catalogs.create') }}"
       class="btn btn-primary">
        + {{ __('Add Catalog') }}
    </a>

</div>


{{-- Catalogs Table --}}
<div class="card border-0 shadow-sm">

    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">
                    <tr>
                        <th class="px-4">{{ __('Name') }}</th>
                        <th>{{ __('Description') }}</th>
                        <th>{{ __('Products') }}</th>
                        <th class="text-end px-4">{{ __('Actions') }}</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse ($catalogs as $catalog)

                        <tr>

                            {{-- Name --}}
                            <td class="px-4">
                                <div class="d-flex align-items-center">

                                    <div class="bg-warning bg-opacity-10 rounded-3 p-2 me-3">
                                        <span>🍯</span>
                                    </div>

                                    <div>
                                        <div class="fw-semibold">
                                            {{ $catalog->name }}
                                        </div>

                                        <small class="text-muted">
                                            {{ __('Catalog') }} #{{ $catalog->id }}
                                        </small>
                                    </div>

                                </div>
                            </td>


                            {{-- Description --}}
                            <td>
                                <span class="text-muted">
                                    {{ Str::limit($catalog->description, 60) }}
                                </span>
                            </td>


                            {{-- Products count --}}
                            <td>

                                <span class="badge bg-light text-dark border">
                                    {{ trans_choice('{1} :count product|[2,*] :count products', $catalog->products_count, ['count' => $catalog->products_count]) }}
                                </span>

                            </td>


                            {{-- Actions --}}
                            <td class="text-end px-4">

                                {{-- Edit --}}
                                <a href="{{ route('admin.catalogs.edit', $catalog) }}"
                                   class="btn btn-outline-primary btn-sm">
                                    {{ __('Edit') }}
                                </a>


                                {{-- Delete --}}
                                @if (auth()->user()->role === 'admin')

                                    <button
                                        type="button"
                                        class="btn btn-danger btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteCatalogModal{{ $catalog->id }}"
                                    >
                                        {{ __('Delete') }}
                                    </button>


                                    {{-- Delete Confirmation Modal --}}
                                    <div
                                        class="modal fade"
                                        id="deleteCatalogModal{{ $catalog->id }}"
                                        tabindex="-1"
                                        aria-labelledby="deleteCatalogModalLabel{{ $catalog->id }}"
                                        aria-hidden="true"
                                    >

                                        <div class="modal-dialog modal-dialog-centered">

                                            <div class="modal-content">

                                                {{-- Modal Header --}}
                                                <div class="modal-header">

                                                    <h5
                                                        class="modal-title"
                                                        id="deleteCatalogModalLabel{{ $catalog->id }}"
                                                    >
                                                        {{ __('Confirm Catalog Deletion') }}
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
                                                        <strong>{{ $catalog->name }}</strong>?
                                                    </p>

                                                    <div class="alert alert-warning mb-0">

                                                        <strong>⚠️ {{ __('Please note:') }}</strong>

                                                        <br>

                                                        {{ __('The products inside this catalog will not be deleted. They will simply become unassigned from this catalog.') }}

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
                                                        action="{{ route('admin.catalogs.destroy', $catalog) }}"
                                                        method="POST"
                                                        class="d-inline"
                                                    >

                                                        @csrf
                                                        @method('DELETE')

                                                        <button
                                                            type="submit"
                                                            class="btn btn-danger"
                                                        >
                                                            {{ __('Yes, Delete Catalog') }}
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
                            <td colspan="4" class="text-center py-5">

                                <div class="text-muted">

                                    <div style="font-size: 2.5rem;">
                                        🍯
                                    </div>

                                    <p class="mb-1 fw-semibold">
                                        {{ __('No catalogs yet') }}
                                    </p>

                                    <small>
                                        {{ __('Create your first catalog to organize your products.') }}
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

@endsection
