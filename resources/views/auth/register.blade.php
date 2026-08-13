@extends('layouts.app')

@section('title', __('Create Account'))

@section('content')

    <div class="auth-page-inline">
        <div class="auth-container">
            <h1>{{ __('Create Account') }}</h1>
            <p class="text-muted text-center mb-4" style="font-size: 14px;">
                {{ __('Track your orders and unlock loyalty discounts') }} 🍯
            </p>

            @if ($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('register.submit') }}">
                @csrf

                <div class="form-group">
                    <label>{{ __('Full Name') }}</label>
                    <input type="text" name="name" value="{{ old('name') }}" required autofocus>
                </div>

                <div class="form-group">
                    <label>{{ __('Email Address') }}</label>
                    <input type="email" name="email" value="{{ old('email') }}" required>
                </div>

                <div class="form-group">
                    <label>{{ __('Password') }}</label>
                    <input type="password" name="password" required>
                </div>

                <div class="form-group">
                    <label>{{ __('Confirm Password') }}</label>
                    <input type="password" name="password_confirmation" required>
                </div>

                <button type="submit" class="btn btn-primary">{{ __('Sign Up') }}</button>
            </form>

            <p class="auth-link mt-3">{{ __('Already have an account?') }} <a href="{{ route('login') }}">{{ __('Login here') }}</a></p>
        </div>
    </div>

@endsection
