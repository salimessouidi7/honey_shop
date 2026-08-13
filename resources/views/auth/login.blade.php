@extends('layouts.app')

@section('title', __('Login'))

@section('content')

    <div class="auth-page-inline">
        <div class="auth-container">
            <h1>{{ __('Welcome Back') }}</h1>

            @if ($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('login.submit') }}">
                @csrf

                <div class="form-group">
                    <label>{{ __('Email') }}</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus>
                </div>

                <div class="form-group">
                    <label>{{ __('Password') }}</label>
                    <input type="password" name="password" required>
                </div>

                <div class="form-group d-flex align-items-center gap-2">
                    <input type="checkbox" id="remember" name="remember" style="width:auto;">
                    <label for="remember" class="mb-0">{{ __('Remember me') }}</label>
                </div>

                <button type="submit" class="btn btn-primary">{{ __('Login') }}</button>
            </form>

            <p class="auth-link mt-3">{{ __("Don't have an account?") }} <a href="{{ route('register') }}">{{ __('Sign up here') }}</a></p>
        </div>
    </div>

@endsection
