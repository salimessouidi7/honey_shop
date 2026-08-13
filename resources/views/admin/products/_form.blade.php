<div class="row g-4">

    {{-- Left column --}}
    <div class="col-lg-8">

        {{-- Basic Information --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">

                <div class="d-flex align-items-center mb-4">
                    <div class="bg-warning bg-opacity-10 rounded-3 p-3 me-3">
                        <span style="font-size: 1.4rem;">🍯</span>
                    </div>

                    <div>
                        <h5 class="mb-1 fw-semibold">{{ __('Product Information') }}</h5>
                        <p class="text-muted mb-0 small">
                            {{ __('Enter the basic information about your honey product.') }}
                        </p>
                    </div>
                </div>

                {{-- Name --}}
                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        {{ __('Product Name') }}
                        <span class="text-danger">*</span>
                    </label>

                    <input
                        type="text"
                        name="name"
                        value="{{ old('name', $product->name ?? '') }}"
                        class="form-control form-control-lg @error('name') is-invalid @enderror"
                        placeholder="{{ __('e.g. Italian Mountain Honey') }}"
                        required>

                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Catalog + Honey Type --}}
                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            {{ __('Catalog') }}
                        </label>

                        <select
                            name="catalog_id"
                            class="form-select form-select-lg @error('catalog_id') is-invalid @enderror">
                            <option value="">— {{ __('Select a catalog') }} —</option>

                            @foreach ($catalogs as $catalog)
                            <option
                                value="{{ $catalog->id }}"
                                @selected(old('catalog_id', $product->catalog_id ?? null) == $catalog->id)
                                >
                                {{ $catalog->name }}
                            </option>
                            @endforeach
                        </select>

                        @error('catalog_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            {{ __('Honey Type') }}
                        </label>

                        <input
                            type="text"
                            name="honey_type"
                            value="{{ old('honey_type', $product->honey_type ?? '') }}"
                            class="form-control form-control-lg @error('honey_type') is-invalid @enderror"
                            placeholder="{{ __('e.g. Acacia, Wildflower...') }}">

                        @error('honey_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                {{-- Description --}}
                <div class="mt-4">
                    <label class="form-label fw-semibold">
                        {{ __('Description') }}
                    </label>

                    <textarea
                        name="description"
                        rows="6"
                        class="form-control @error('description') is-invalid @enderror"
                        placeholder="{{ __('Describe the taste, origin, characteristics and other details of this honey...') }}">{{ old('description', $product->description ?? '') }}</textarea>

                    @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

            </div>
        </div>


        {{-- Pricing & Inventory --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">

                <div class="d-flex align-items-center mb-4">
                    <div class="bg-success bg-opacity-10 rounded-3 p-3 me-3">
                        <span style="font-size: 1.4rem;">📦</span>
                    </div>

                    <div>
                        <h5 class="mb-1 fw-semibold">{{ __('Pricing & Inventory') }}</h5>
                        <p class="text-muted mb-0 small">
                            {{ __('Manage the product price and available stock.') }}
                        </p>
                    </div>
                </div>

                <div class="row g-4">

                    {{-- Price --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            {{ __('Price') }}
                            <span class="text-danger">*</span>
                        </label>

                        <div class="input-group input-group-lg">
                            <span class="input-group-text">$</span>

                            <input
                                type="number"
                                step="0.01"
                                min="0"
                                name="price"
                                value="{{ old('price', $product->price ?? '') }}"
                                class="form-control @error('price') is-invalid @enderror"
                                placeholder="0.00"
                                required>
                        </div>

                        @error('price')
                        <div class="text-danger small mt-1">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>


                    {{-- Stock --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            {{ __('Stock') }}
                            <span class="text-danger">*</span>
                        </label>

                        <div class="input-group input-group-lg">
                            <input
                                type="number"
                                min="0"
                                name="stock"
                                value="{{ old('stock', $product->stock ?? 0) }}"
                                class="form-control @error('stock') is-invalid @enderror"
                                placeholder="0"
                                required>

                            <span class="input-group-text">
                                {{ __('units') }}
                            </span>
                        </div>

                        @error('stock')
                        <div class="text-danger small mt-1">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                </div>

            </div>
        </div>


        {{-- Discount --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">

                <div class="d-flex align-items-center mb-4">
                    <div class="bg-danger bg-opacity-10 rounded-3 p-3 me-3">
                        <span style="font-size: 1.4rem;">🏷️</span>
                    </div>

                    <div>
                        <h5 class="mb-1 fw-semibold">{{ __('Discount') }}</h5>
                        <p class="text-muted mb-0 small">
                            {{ __('Optional. Applies to everyone - guests and account holders alike.') }}
                        </p>
                    </div>
                </div>

                <div class="row g-4">

                    {{-- Discount type --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            {{ __('Discount Type') }}
                        </label>

                        @php $currentType = old('discount_type', $product->discount_type ?? ''); @endphp

                        <select
                            name="discount_type"
                            id="discount_type"
                            class="form-select form-select-lg @error('discount_type') is-invalid @enderror">
                            <option value="" @selected($currentType === '')>{{ __('No discount') }}</option>
                            <option value="percent" @selected($currentType === 'percent')>{{ __('Percentage off (%)') }}</option>
                            <option value="fixed" @selected($currentType === 'fixed')>{{ __('Fixed amount off ($)') }}</option>
                        </select>

                        @error('discount_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Discount value --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            {{ __('Discount Value') }}
                        </label>

                        <input
                            type="number"
                            step="0.01"
                            min="0"
                            name="discount_value"
                            id="discount_value"
                            value="{{ old('discount_value', $product->discount_value ?? '') }}"
                            class="form-control form-control-lg @error('discount_value') is-invalid @enderror"
                            placeholder="{{ __('e.g. 20 for 20%, or 3 for $3 off') }}">

                        @error('discount_value')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

            </div>
        </div>

    </div>


    {{-- Right column --}}
    <div class="col-lg-4">

        {{-- Image --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">

                <div class="d-flex align-items-center mb-4">
                    <div class="bg-info bg-opacity-10 rounded-3 p-3 me-3">
                        <span style="font-size: 1.4rem;">🖼️</span>
                    </div>

                    <div>
                        <h5 class="mb-1 fw-semibold">{{ __('Product Image') }}</h5>
                        <p class="text-muted mb-0 small">
                            {{ __('Add the image path.') }}
                        </p>
                    </div>
                </div>

                {{-- Image Preview --}}
                @if (!empty($product?->image_url))
                <div class="mb-3 text-center">

                    <img
                        src="{{ asset($product->image_url) }}"
                        alt="{{ $product->name }}"
                        class="img-fluid rounded-3 shadow-sm"
                        style="width: 100%; height: 220px; object-fit: cover;">

                </div>
                @else
                <div
                    class="rounded-3 mb-3 d-flex flex-column align-items-center justify-content-center"
                    style="
                        height: 220px;
                        background: #f8f9fa;
                        border: 2px dashed #dee2e6;
                    ">
                    <span style="font-size: 3rem;">🍯</span>

                    <span class="text-muted mt-2">
                        {{ __('No image selected') }}
                    </span>
                </div>
                @endif


                <label class="form-label fw-semibold">
                    {{ __('Image Path') }}
                </label>

                <textarea
                    name="image_url"
                    rows="2"
                    class="form-control @error('image_url') is-invalid @enderror"
                    placeholder="images/italian_honey.jpg">{{ old('image_url', $product->image_url ?? '') }}</textarea>

                @error('image_url')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror

                <div class="form-text mt-2">
                    {{ __('Example:') }}
                    <code>images/italian_honey.jpg</code>
                </div>

            </div>
        </div>


        {{-- Product Status --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">

                <h6 class="fw-semibold mb-3">
                    {{ __('Product Summary') }}
                </h6>

                <div class="d-flex justify-content-between py-2 border-bottom">
                    <span class="text-muted">{{ __('Catalog') }}</span>

                    <span class="fw-medium">
                        {{ old('catalog_id', $product->catalog_id ?? null) ? __('Selected') : __('None') }}
                    </span>
                </div>

                <div class="d-flex justify-content-between py-2 border-bottom">
                    <span class="text-muted">{{ __('Price') }}</span>

                    @php
                        $summaryType = old('discount_type', $product->discount_type ?? '');
                        $summaryValue = (float) old('discount_value', $product->discount_value ?? 0);
                        $summaryPrice = (float) old('price', $product->price ?? 0);
                        $summaryHasDiscount = $summaryType !== '' && $summaryValue > 0;
                        $summaryFinal = $summaryHasDiscount
                            ? max(0, round($summaryPrice - ($summaryType === 'percent' ? $summaryPrice * $summaryValue / 100 : $summaryValue), 2))
                            : $summaryPrice;
                    @endphp

                    @if ($summaryHasDiscount)
                        <span class="fw-medium text-end">
                            <span class="text-muted text-decoration-line-through small d-block">
                                ${{ number_format($summaryPrice, 2) }}
                            </span>
                            <span class="text-danger">${{ number_format($summaryFinal, 2) }}</span>
                        </span>
                    @else
                        <span class="fw-medium">
                            ${{ number_format($summaryPrice, 2) }}
                        </span>
                    @endif
                </div>

                <div class="d-flex justify-content-between py-2">
                    <span class="text-muted">{{ __('Stock') }}</span>

                    <span class="fw-medium">
                        {{ old('stock', $product->stock ?? 0) }} {{ __('units') }}
                    </span>
                </div>

            </div>
        </div>

    </div>

</div>