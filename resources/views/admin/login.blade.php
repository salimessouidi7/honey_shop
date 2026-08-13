<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Admin Login') }} - {{ __('Honey Shop') }}</title>

    @if (app()->getLocale() === 'ar')
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    @else
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    @endif

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Playfair+Display:wght@600;700&family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body class="{{ app()->getLocale() === 'ar' ? 'font-arabic' : '' }}">

    <div class="auth-page">
        <div class="auth-container">
            <h1>🍯 {{ __('Admin Login') }}</h1>

            @if ($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('admin.login.submit') }}">
                @csrf

                <div class="form-group">
                    <label>{{ __('Email') }}</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="you@honeyshop.test" required autofocus>
                </div>

                <div class="form-group">
                    <label>{{ __('Password') }}</label>
                    <input type="password" name="password" placeholder="••••••••" required>
                </div>

                <button type="submit" class="btn btn-primary">{{ __('Login') }}</button>
            </form>

            <div class="text-center mt-3">
                <a href="{{ route('lang.switch', 'en') }}" class="small">English</a> |
                <a href="{{ route('lang.switch', 'ar') }}" class="small">العربية</a>
            </div>
        </div>
    </div>

</body>
</html>
