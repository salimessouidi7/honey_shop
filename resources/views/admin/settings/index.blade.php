@extends('admin.layout')

@section('title', __('Settings'))

@section('content')

    <h1 class="mb-1">{{ __('Feature Settings') }}</h1>
    <p class="text-muted mb-4">{{ __('Turn optional features on or off for your shop.') }}</p>

    <div class="card">
        @forelse ($features as $feature)
            <div class="d-flex justify-content-between align-items-center p-4 border-bottom">

                <div>
                    <h5 class="mb-1">
                        {{ $feature->name }}
                        @if ($feature->enabled)
                            <span class="badge bg-success ms-2">{{ __('Enabled') }}</span>
                        @else
                            <span class="badge bg-secondary ms-2">{{ __('Disabled') }}</span>
                        @endif
                    </h5>
                    <p class="text-muted mb-0 small">{{ $feature->description }}</p>
                </div>

                <form action="{{ route('admin.settings.toggle', $feature) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn {{ $feature->enabled ? 'btn-outline-danger' : 'btn-primary' }}">
                        {{ $feature->enabled ? __('Disable') : __('Enable') }}
                    </button>
                </form>

            </div>
        @empty
            <p class="text-muted p-4 mb-0">{{ __('No features registered yet.') }}</p>
        @endforelse
    </div>

@endsection
