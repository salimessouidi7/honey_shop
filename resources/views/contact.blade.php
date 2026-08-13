@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')

    <h1 class="mb-4 text-center">Contact Us</h1>

    <div class="card p-4 mx-auto" style="max-width: 600px;">
        <form method="POST" action="{{ route('contact.store') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" value="{{ old('name', auth()->user()->name ?? '') }}"
                       class="form-control @error('name') is-invalid @enderror" required>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}"
                       class="form-control @error('email') is-invalid @enderror" required>
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Subject</label>
                <input type="text" name="subject" value="{{ old('subject') }}"
                       class="form-control @error('subject') is-invalid @enderror" required>
                @error('subject') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Message</label>
                <textarea name="message" rows="5" class="form-control @error('message') is-invalid @enderror" required>{{ old('message') }}</textarea>
                @error('message') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <button type="submit" class="btn btn-primary">Send Message</button>
        </form>
    </div>

    @auth
        @if (auth()->user()->role === 'customer')
            <div class="text-center mt-3">
                <a href="{{ route('messages.index') }}" class="btn btn-outline-secondary">View My Messages</a>
            </div>
        @endif
    @endauth

@endsection