<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/svg+xml" href="https://laravel.com/img/logomark.min.svg">
    <title>@yield('title', config('app.name', 'paud_teratai'))</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --blue-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --green-gradient: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
            --yellow-gradient: linear-gradient(135deg, #ecc94b 0%, #d69e2e 100%);
            --pink-gradient: linear-gradient(135deg, #ed64a6 0%, #d53f8c 100%);
            --red-gradient: linear-gradient(135deg, #f56565 0%, #e53e3e 100%);
            --purple-gradient: linear-gradient(135deg, #9f7aea 0%, #805ad5 100%);
            --bg-color: #f8f9fa;
            --card-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-color);
            padding-bottom: 80px; /* Space for bottom nav */
            -webkit-tap-highlight-color: transparent;
        }

        .mobile-header {
            background: white;
            padding: 1rem;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0,0,0,0.02);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .user-avatar-header {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: var(--primary-gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 0.8rem;
        }

        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: white;
            height: 65px;
            display: flex;
            align-items: center;
            justify-content: space-around;
            box-shadow: 0 -2px 15px rgba(0,0,0,0.05);
            z-index: 1000;
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
        }

        .nav-item-mobile {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-decoration: none;
            color: #adb5bd;
            font-size: 0.75rem;
            transition: all 0.3s;
        }

        .nav-item-mobile i {
            font-size: 1.4rem;
            margin-bottom: 2px;
        }

        .nav-item-mobile.active {
            color: #f5576c;
            font-weight: 600;
        }

        .nav-item-mobile.active i {
            transform: translateY(-2px);
            filter: drop-shadow(0 2px 4px rgba(245, 87, 108, 0.2));
        }

        .card-mobile {
            border: none;
            border-radius: 20px;
            box-shadow: var(--card-shadow);
            margin-bottom: 1rem;
            overflow: hidden;
        }

        .btn-gradient {
            background: var(--primary-gradient);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 0.6rem 1.2rem;
            font-weight: 600;
            transition: transform 0.2s;
        }

        .btn-gradient:active {
            transform: scale(0.95);
        }

        .badge-orangtua {
            background: var(--primary-gradient);
            color: white;
            border-radius: 8px;
            padding: 4px 10px;
        }

        /* Aspect Specific Styles */
        .aspek-icon-box {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Agama/Moral - Gold/Yellow */
        .aspek-agama { --aspek-color: #f1c40f; --aspek-bg: rgba(241, 196, 15, 0.1); }
        /* Fisik-Motorik - Green */
        .aspek-fisik { --aspek-color: #2ecc71; --aspek-bg: rgba(46, 204, 113, 0.1); }
        /* Kognitif - Light Blue */
        .aspek-kognitif { --aspek-color: #3498db; --aspek-bg: rgba(52, 152, 219, 0.1); }
        /* Bahasa - Purple/Dark Blue */
        .aspek-bahasa { --aspek-color: #9b59b6; --aspek-bg: rgba(155, 89, 182, 0.1); }
        /* Sosial-Emosional - Red/Pink */
        .aspek-sosial { --aspek-color: #e91e63; --aspek-bg: rgba(233, 30, 99, 0.1); }
        /* Seni - Elegant Pink/Purple Gradient (Less Bright) */
        .aspek-seni { 
            --aspek-color: #9d174d; 
            --aspek-bg: rgba(157, 23, 77, 0.08);
            --aspek-gradient: linear-gradient(135deg, #be185d 50%);
        }

        .bg-aspek { background-color: var(--aspek-bg) !important; }
        .text-aspek { color: var(--aspek-color) !important; }
        .border-aspek { border-color: var(--aspek-color) !important; }
        .progress-aspek { background-color: var(--aspek-color) !important; }
        .badge-aspek { background-color: var(--aspek-bg); color: var(--aspek-color); }
        
        .aspek-seni .text-aspek { color: #be185d !important; }

        /* Chart adjustments for mobile */
        canvas {
            max-width: 100% !important;
        }
    </style>
    @stack('styles')
</head>
<body>
    <header class="mobile-header">
        <div class="d-flex align-items-center gap-2">
            <img src="{{ asset('images/logo-paud.png') }}" alt="Logo" height="30">
            <span class="fw-bold text-dark">PAUD Teratai</span>
        </div>
    </header>

    <main class="container py-3">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-4" role="alert">
                <i class="bi bi-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <nav class="bottom-nav">
        <a href="{{ route('orangtua.dashboard') }}" class="nav-item-mobile {{ request()->routeIs('orangtua.dashboard') ? 'active' : '' }}">
            <i class="bi bi-house-door{{ request()->routeIs('orangtua.dashboard') ? '-fill' : '' }}"></i>
            <span>Home</span>
        </a>
        <a href="{{ route('orangtua.perkembangan.index') }}" class="nav-item-mobile {{ request()->routeIs('orangtua.perkembangan*') ? 'active' : '' }}">
            <i class="bi bi-journal-text"></i>
            <span>Perkembangan</span>
        </a>
        <a href="#" class="nav-item-mobile" onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();">
            <i class="bi bi-box-arrow-right"></i>
            <span>Keluar</span>
        </a>
        <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </nav>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @stack('scripts')
</body>
</html>