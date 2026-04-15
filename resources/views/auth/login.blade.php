<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in | SPS Teratai</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-blue: #2d62ed;
            --bg-light: #f8fafc;
            --text-main: #1e293b;
            --text-muted: #64748b;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-light);
            margin: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow-x: hidden;
        }

        /* Decorative Illustrations */
        .decor {
            position: absolute;
            z-index: 0;
            pointer-events: none;
        }
        
        .decor-star { color: #fbbf24; animation: twinkle 3s infinite ease-in-out; }
        .decor-star-1 { top: 10%; left: 15%; font-size: 1.5rem; }
        .decor-star-2 { top: 25%; left: 25%; font-size: 1rem; animation-delay: 1s; }
        .decor-star-3 { bottom: 15%; right: 20%; font-size: 2rem; animation-delay: 2s; }
        
        .decor-moon {
            top: 15%;
            right: 15%;
            font-size: 4rem;
            color: #e2e8f0;
            filter: drop-shadow(0 0 20px rgba(226, 232, 240, 0.4));
            animation: float 6s infinite ease-in-out;
        }

        .decor-planet {
            top: 45%;
            left: 8%;
            font-size: 3.5rem;
            color: #94a3b8;
            animation: float 8s infinite ease-in-out;
        }

        .decor-cloud {
            color: #f1f5f9;
            opacity: 0.8;
            animation: move-lr 20s infinite linear;
        }
        .decor-cloud-1 { top: 20%; left: -100px; font-size: 5rem; }
        .decor-cloud-2 { bottom: 25%; right: -100px; font-size: 4rem; animation-delay: -10s; }

        .decor-rocket {
            bottom: 10%;
            left: 15%;
            font-size: 2.5rem;
            color: #2d62ed;
            transform: rotate(-45deg);
            animation: float 4s infinite ease-in-out;
        }

        @keyframes twinkle {
            0%, 100% { opacity: 0.3; transform: scale(0.8); }
            50% { opacity: 1; transform: scale(1.2); }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }

        @keyframes move-lr {
            from { transform: translateX(-100px); }
            to { transform: translateX(calc(100vw + 100px)); }
        }

        .login-container {
            width: 100%;
            max-width: 420px;
            padding: 20px;
            z-index: 1;
            text-align: center;
        }

        .brand-logo {
            margin-bottom: 32px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
        }

        .brand-logo img {
            width: 140px; /* Diperbesar signifikan agar terlihat 'wah' */
            height: 140px;
            object-fit: contain;
            filter: drop-shadow(0 12px 24px rgba(0,0,0,0.12));
            transition: transform 0.3s ease;
        }

        .brand-logo img:hover {
            transform: scale(1.05);
        }

        .brand-name {
            font-weight: 800;
            font-size: 1.8rem; /* Diperbesar dari 1.6rem */
            color: var(--text-main);
            letter-spacing: -0.025em;
            margin-top: 15px;
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .login-card {
            background: white;
            padding: 40px;
            border-radius: 24px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 10px 10px -5px rgba(0, 0, 0, 0.02);
            border: 1px solid rgba(0,0,0,0.02);
        }

        .login-card h1 {
            font-weight: 700;
            font-size: 1.75rem;
            color: var(--text-main);
            margin-bottom: 8px;
        }

        .login-card p.subtitle {
            color: var(--text-muted);
            font-size: 0.95rem;
            margin-bottom: 32px;
        }

        .form-label {
            display: block;
            text-align: left;
            font-size: 0.85rem;
            font-weight: 500;
            color: var(--text-muted);
            margin-bottom: 6px;
        }

        .input-wrapper {
            position: relative;
            margin-bottom: 20px;
        }

        .form-control {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 0.95rem;
            transition: all 0.2s;
            color: var(--text-main);
        }

        .form-control:focus {
            background-color: #fff;
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 4px rgba(45, 98, 237, 0.1);
        }

        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            background: none;
            color: #cbd5e1;
            padding: 4px;
            cursor: pointer;
        }

        .forgot-link {
            display: block;
            color: var(--primary-blue);
            font-size: 0.9rem;
            font-weight: 600;
            text-decoration: none;
            margin-top: 24px;
        }

        .forgot-link:hover {
            text-decoration: underline;
        }

        .btn-signin {
            background-color: var(--primary-blue);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 14px;
            width: 100%;
            font-weight: 600;
            font-size: 1rem;
            margin-top: 10px;
            transition: all 0.2s;
        }

        .btn-signin:hover {
            background-color: #1d4ed8;
            transform: translateY(-1px);
            box-shadow: 0 10px 15px -3px rgba(45, 98, 237, 0.3);
        }

        .footer {
            margin-top: 30px; /* Diperkecil dari 60px */
            font-size: 0.8rem;
            color: var(--text-muted);
            text-align: center;
        }

        .footer a {
            color: var(--text-muted);
            text-decoration: none;
        }

        .footer a:hover {
            color: var(--text-main);
        }

        /* SVG Illustrations using CSS Masks or inline SVG for professional look */
        .svg-icon {
            fill: currentColor;
        }
    </style>
</head>
<body>

    <!-- Decorative elements -->
    <div class="decor decor-star decor-star-1"><i class="bi bi-star-fill"></i></div>
    <div class="decor decor-star decor-star-2"><i class="bi bi-star-fill"></i></div>
    <div class="decor decor-star decor-star-3"><i class="bi bi-star-fill"></i></div>
    <div class="decor decor-moon"><i class="bi bi-moon-stars-fill"></i></div>
    <div class="decor decor-planet"><i class="bi bi-globe-americas"></i></div>
    <div class="decor decor-rocket"><i class="bi bi-rocket-takeoff-fill"></i></div>
    <div class="decor decor-cloud decor-cloud-1"><i class="bi bi-cloud-fill"></i></div>
    <div class="decor decor-cloud decor-cloud-2"><i class="bi bi-cloud-fill"></i></div>

    <div class="login-container">
        <div class="login-card">
            <div class="brand-logo">
                <img src="{{ asset('images/logo-paud.png') }}" alt="Logo PAUD">
                <span class="brand-name">SPS Teratai</span>
            </div>

            @if($errors->any())
                <div class="alert alert-danger border-0 small py-2 px-3 mb-4 rounded-3 text-center">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <div class="text-start">
                    <label class="form-label">Email</label>
                    <div class="input-wrapper">
                        <input type="email" name="email" class="form-control w-100" placeholder="Email" value="{{ old('email') }}" required autofocus>
                    </div>
                </div>

                <div class="text-start">
                    <label class="form-label">Password</label>
                    <div class="input-wrapper">
                        <input type="password" name="password" id="password" class="form-control w-100" placeholder="Password" required>
                        <button type="button" class="toggle-password" id="togglePassword">
                            <i class="bi bi-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn-signin">Sign in</button>
            </form>
        </div>

        <div class="footer">
            <span>© SPS Teratai {{ date('Y') }}</span>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.querySelector('#togglePassword');
            const password = document.querySelector('#password');
            const eyeIcon = document.querySelector('#eyeIcon');

            togglePassword.addEventListener('click', function() {
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                eyeIcon.classList.toggle('bi-eye');
                eyeIcon.classList.toggle('bi-eye-slash');
            });
        });
    </script>
</body>
</html>
