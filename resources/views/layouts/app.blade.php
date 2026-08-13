<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', __('Honey Shop'))</title>

    @if (app()->getLocale() === 'ar')
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    @else
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    @endif

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Playfair+Display:wght@600;700&family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

</head>
<body class="{{ app()->getLocale() === 'ar' ? 'font-arabic' : '' }}">

    <nav class="navbar navbar-expand-lg sticky-top honey-navbar">
        <div class="container">
            <a class="navbar-brand honey-brand" href="{{ route('home') }}">
                <span class="honey-brand-icon">🍯</span> {{ __('Honey Shop') }}
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">{{ __('Home') }}</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link position-relative" href="{{ route('cart.index') }}">
                            🛒 {{ __('Cart') }}
                            @php $cartCount = collect(session('cart', []))->sum(); @endphp
                            @if ($cartCount > 0)
                                <span class="honey-cart-badge">{{ $cartCount }}</span>
                            @endif
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}">✉️ {{ __('Contact') }}</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            🌐 {{ app()->getLocale() === 'ar' ? 'العربية' : 'English' }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('lang.switch', 'en') }}">English</a></li>
                            <li><a class="dropdown-item" href="{{ route('lang.switch', 'ar') }}">العربية</a></li>
                        </ul>
                    </li>

                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endguest

                    @auth
                        <li class="nav-item d-flex align-items-center px-2">
                            @include('partials.notifications-dropdown')
                        </li>

                        @if (auth()->user()->role === 'customer')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('orders.history') }}">
                                    📦 {{ __('My Orders') }}
                                    @if (auth()->user()->loyaltyDiscountPercent() > 0)
                                        <span class="honey-loyalty-badge">{{ auth()->user()->loyaltyDiscountPercent() }}%</span>
                                    @endif
                                </a>
                            </li>
                        @endif

                        @if (in_array(auth()->user()->role, ['admin', 'staff']))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.dashboard') }}">⚙️ {{ __('Admin Panel') }}</a>
                            </li>
                        @endif

                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="nav-link border-0 bg-transparent">{{ __('Logout') }}</button>
                            </form>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main class="container my-4">

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @yield('content')

    </main>

    <footer class="honey-footer">
        <div class="container">
            <div class="row gy-4">
                <div class="col-md-4">
                    <h5 class="honey-footer-brand">🍯 {{ __('Honey Shop') }}</h5>
                    <p class="text-white-50 mb-0">
                        {{ __('Pure, natural honey harvested with care and delivered straight to your door.') }}
                    </p>
                </div>

                <div class="col-md-4">
                    <h6 class="text-uppercase mb-3">{{ __('Quick Links') }}</h6>
                    <ul class="list-unstyled honey-footer-links">
                        <li><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                        <li><a href="{{ route('cart.index') }}">{{ __('Cart') }}</a></li>
                        @auth
                            @if (auth()->user()->role === 'customer')
                                <li><a href="{{ route('orders.history') }}">{{ __('My Orders') }}</a></li>
                            @endif
                        @endauth
                    </ul>
                </div>

                <div class="col-md-4">
                    <h6 class="text-uppercase mb-3">{{ __('Contact') }}</h6>
                    <ul class="list-unstyled text-white-50">
                        <li>📍 {{ __('Tunis, Tunisia') }}</li>
                        <li>✉️ salimsouidi7@gmail.com</li>
                    </ul>
                </div>
            </div>

            <hr class="border-secondary my-4">

            <p class="text-center text-white-50 mb-0 small">
                &copy; {{ date('Y') }} Salim Souidi. {{ __('All rights reserved.') }}
            </p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
