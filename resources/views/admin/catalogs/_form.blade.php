<div class="row justify-content-center">

<div class="col-lg-8">

    {{-- Catalog Information --}}
    <div class="card border-0 shadow-sm">

        <div class="card-body p-4">

            {{-- Header --}}
            <div class="d-flex align-items-center mb-4">

                <div class="bg-warning bg-opacity-10 rounded-3 p-3 me-3">
                    <span style="font-size: 1.5rem;">🍯</span>
                </div>

                <div>
                    <h5 class="mb-1 fw-semibold">
                        {{ __('Catalog Information') }}
                    </h5>

                    <p class="text-muted mb-0 small">
                        {{ __('Create a catalog to organize your honey products.') }}
                    </p>
                </div>

            </div>


            {{-- Name --}}
            <div class="mb-4">

                <label class="form-label fw-semibold">
                    {{ __('Catalog Name') }}
                    <span class="text-danger">*</span>
                </label>

                <input
                    type="text"
                    name="name"
                    value="{{ old('name', $catalog->name ?? '') }}"
                    class="form-control form-control-lg @error('name') is-invalid @enderror"
                    placeholder="{{ __('e.g. Premium Honey') }}"
                    required
                >

                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>


            {{-- Description --}}
            <div class="mb-2">

                <label class="form-label fw-semibold">
                    {{ __('Description') }}
                </label>

                <textarea
                    name="description"
                    rows="6"
                    class="form-control @error('description') is-invalid @enderror"
                    placeholder="{{ __('Describe what kind of products belong to this catalog...') }}"
                >{{ old('description', $catalog->description ?? '') }}</textarea>

                @error('description')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

                <div class="form-text">
                    {{ __('Add a short description to help administrators understand the purpose of this catalog.') }}
                </div>

            </div>

        </div>

    </div>

</div>
</div>
