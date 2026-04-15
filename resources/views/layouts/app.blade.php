<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/logo-paud.png') }}">
    <title>@yield('title', config('app.name', 'paud_teratai'))</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8f9fa;
        }
        .sidebar {
            min-height: 100vh;
            background: var(--primary-gradient);
            box-shadow: 4px 0 15px rgba(0,0,0,0.05);
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,.85);
            padding: 1rem;
            transition: all 0.2s ease-in-out;
        }
        .sidebar .nav-link:hover {
            color: white;
            background: rgba(255,255,255,.12);
            padding-left: 1.25rem;
        }
        .sidebar .nav-link.active {
            color: white;
            background: rgba(255,255,255,.2);
        }
        .sidebar .nav-link i {
            margin-right: 10px;
        }
        .content-wrapper {
            background: #f8f9fa;
            min-height: 100vh;
        }
        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .04);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, .06);
        }
        .card-header {
            background: white;
            border-bottom: 1px solid rgba(0, 0, 0, .05);
            border-radius: 20px 20px 0 0 !important;
            padding: 1.5rem;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        }
        .badge-guru {
            background: rgba(255,255,255,0.2);
            color: white;
            border: 1px solid rgba(255,255,255,0.3);
        }
        .badge-orangtua {
            background: rgba(255,255,255,0.2);
            color: white;
            border: 1px solid rgba(255,255,255,0.3);
        }
        .metric-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(102, 126, 234, .12);
            color: #667eea;
        }
        .metric-sub {
            font-size: .9rem;
            color: rgba(75, 85, 99, .9);
        }
        .text-purple {
            color: #764ba2 !important;
        }
        .bg-purple {
            background-color: #764ba2 !important;
        }
        .bg-soft-purple {
            background-color: rgba(118, 75, 162, 0.1) !important;
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
        /* Seni - Vibrant Pink/Purple Gradient */
        .aspek-seni { 
            --aspek-color: #d946ef; 
            --aspek-bg: rgba(217, 70, 239, 0.1);
            --aspek-gradient: linear-gradient(135deg, #d946ef 0%, #6c5ce7 100%);
        }

        .bg-aspek { background-color: var(--aspek-bg) !important; }
        .text-aspek { color: var(--aspek-color) !important; }
        .border-aspek { border-color: var(--aspek-color) !important; }
        .progress-aspek { background-color: var(--aspek-color) !important; }
        .badge-aspek { background-color: var(--aspek-bg); color: var(--aspek-color); }
        
        /* Special case for Seni gradient icons */
        .aspek-seni .aspek-icon-box {
            background: var(--aspek-gradient) !important;
            color: white !important;
        }
        .aspek-seni .text-aspek { color: #d946ef !important; }
    </style>
    @stack('styles')

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            @auth
                @include('layouts.sidebar')
            @endauth

            <!-- Main Content -->
            <div class="@auth col-md-9 col-lg-10 @else col-12 @endauth content-wrapper p-4">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>