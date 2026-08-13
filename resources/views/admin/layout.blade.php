<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', __('Dashboard')) - {{ __('Honey Shop') }} {{ __('Admin') }}</title>

    @if (app()->getLocale() === 'ar')
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    @else
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    @endif

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Playfair+Display:wght@600;700&family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body class="{{ app()->getLocale() === 'ar' ? 'font-arabic' : '' }}">

    <div class="dashboard-page">

        <aside class="sidebar">
            <h2>🍯 {{ __('Honey Admin') }}</h2>
            <ul class="sidebar-menu">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        📊 {{ __('Dashboard') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                        🍯 {{ __('Products') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.catalogs.index') }}" class="{{ request()->routeIs('admin.catalogs.*') ? 'active' : '' }}">
                        🗂️ {{ __('Catalogs') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                        📦 {{ __('Orders') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.messages.index') }}" class="{{ request()->routeIs('admin.messages.*') ? 'active' : '' }}">
                        ✉️ {{ __('Messages') }}
                        @php $openMessages = \App\Models\ContactMessage::where('status', 'open')->count(); @endphp
                        @if ($openMessages > 0)
                            <span class="honey-loyalty-badge">{{ $openMessages }}</span>
                        @endif
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.comments.index') }}" class="{{ request()->routeIs('admin.comments.*') ? 'active' : '' }}">
                        💬 {{ __('Comments') }}
                    </a>
                </li>
                @if (auth()->user()->role === 'admin')
                    <li>
                        <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                            👤 {{ __('Admin Users') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.settings.index') }}" class="{{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                            ⚙️ {{ __('Settings') }}
                        </a>
                    </li>
                @endif
                <li><a href="{{ route('home') }}">🌐 {{ __('View Site') }}</a></li>
            </ul>
        </aside>

        <div class="main-content">

            <div class="header">
                <h1>@yield('title', __('Dashboard'))</h1>

                <div class="user-profile">
                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color:#555;">
                            🌐 {{ app()->getLocale() === 'ar' ? 'العربية' : 'English' }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('lang.switch', 'en') }}">English</a></li>
                            <li><a class="dropdown-item" href="{{ route('lang.switch', 'ar') }}">العربية</a></li>
                        </ul>
                    </div>

                    @include('partials.notifications-dropdown')

                    <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                    <div>
                        <div>{{ auth()->user()->name }}</div>
                        <small class="text-muted">{{ __(ucfirst(auth()->user()->role)) }}</small>
                    </div>
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="logout-btn">{{ __('Logout') }}</button>
                    </form>
                </div>
            </div>

            <div class="content">

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                @yield('content')

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
