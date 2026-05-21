<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'IQInsight') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Sora:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --bg-primary: #020617;
            --bg-secondary: #0b1224;
            --bg-tertiary: #111827;
            --surface-elevated: #0f172a;
            --surface-card: #0b1224;
            --surface-overlay: #111827;
            --text-primary: #e5e7eb;
            --text-secondary: #9ca3af;
            --text-tertiary: #6b7280;
            --text-disabled: #4b5563;
            --accent-primary: #22d3ee;
            --accent-secondary: #f97316;
            --accent-success: #22c55e;
            --accent-warning: #f59e0b;
            --accent-error: #ef4444;
            --accent-info: #38bdf8;
            --border-default: #1f2937;
            --border-subtle: #0b1224;
            --border-strong: #2d3a52;
            --interactive-hover: #111827;
            --interactive-active: #0f172a;
            --interactive-focus: #22d3ee;
            --glow-strong: 0 25px 60px rgba(34, 211, 238, 0.12), 0 0 0 1px rgba(255,255,255,0.02);
        }

        * {
            font-family: 'Space Grotesk', 'Sora', 'Segoe UI', system-ui, -apple-system, sans-serif;
        }

        body {
            background-color: var(--bg-primary);
            background-image:
                radial-gradient(circle at 15% 20%, rgba(34, 211, 238, 0.12), transparent 35%),
                radial-gradient(circle at 80% 0%, rgba(249, 115, 22, 0.12), transparent 32%),
                radial-gradient(circle at 75% 65%, rgba(56, 189, 248, 0.08), transparent 42%),
                linear-gradient(145deg, rgba(255,255,255,0.02), rgba(255,255,255,0));
            color: var(--text-primary);
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: fixed;
            inset: -10%;
            background:
                radial-gradient(circle at 20% 20%, rgba(34, 211, 238, 0.18), transparent 35%),
                radial-gradient(circle at 80% 10%, rgba(249, 115, 22, 0.15), transparent 28%);
            filter: blur(60px);
            z-index: -1;
            pointer-events: none;
        }

        body::after {
            content: '';
            position: fixed;
            inset: 0;
            background-image:
                linear-gradient(rgba(255, 255, 255, 0.02) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.015) 1px, transparent 1px);
            background-size: 200px 200px, 200px 200px;
            opacity: 0.35;
            z-index: -1;
            pointer-events: none;
        }

        a {
            color: var(--accent-primary);
        }

        .navbar {
            background: rgba(2, 6, 23, 0.9);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-strong);
            box-shadow: 0 10px 40px rgba(0,0,0,0.35);
        }

        .navbar-brand {
            letter-spacing: 0.5px;
        }

        .nav-link, .navbar-brand {
            color: var(--text-primary) !important;
        }

        .nav-link.active {
            color: var(--accent-primary) !important;
        }

        .nav-link:hover {
            color: #fff !important;
        }

        .navbar-toggler {
            border-color: var(--border-default);
        }

        .glass {
            background: linear-gradient(150deg, rgba(255,255,255,0.06), rgba(255,255,255,0.02));
            border: 1px solid var(--border-strong);
            box-shadow: 0 25px 70px rgba(0,0,0,0.55), 0 0 0 1px rgba(255,255,255,0.03);
            backdrop-filter: blur(12px);
        }

        .card {
            background: radial-gradient(120% 120% at 20% 20%, rgba(34,211,238,0.06), rgba(2,6,23,0)) var(--surface-card);
            border: 1px solid var(--border-default);
            color: var(--text-primary);
            box-shadow: 0 10px 40px rgba(0,0,0,0.35);
            transition: all 0.25s ease;
            position: relative;
            overflow: hidden;
        }

        .card::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(120deg, rgba(34,211,238,0.08), rgba(249,115,22,0.05));
            opacity: 0;
            transition: opacity 0.25s ease;
        }

        .card > * {
            position: relative;
            z-index: 1;
        }

        .card:hover {
            border-color: var(--interactive-focus);
            transform: translateY(-3px);
            box-shadow: 0 18px 50px rgba(34,211,238,0.15);
        }

        .card:hover::before {
            opacity: 1;
        }

        .list-group-item {
            border-color: var(--border-default) !important;
        }

        .btn-accent {
            background: linear-gradient(120deg, var(--accent-primary), var(--accent-secondary));
            color: #0b0f1a;
            font-weight: 600;
            border: 1px solid rgba(255,255,255,0.08);
            box-shadow: 0 10px 35px rgba(34,211,238,0.25);
            transition: transform 0.2s ease, box-shadow 0.2s ease, filter 0.2s ease;
        }

        .btn-accent:hover {
            transform: translateY(-2px);
            box-shadow: 0 16px 45px rgba(249,115,22,0.2);
            filter: brightness(1.05);
        }

        .btn-outline-light {
            border-color: var(--border-strong);
            color: var(--text-primary);
            background: linear-gradient(120deg, rgba(255,255,255,0.04), rgba(255,255,255,0.02));
        }

        .btn-outline-light:hover {
            border-color: var(--accent-primary);
            color: #fff;
            box-shadow: 0 10px 30px rgba(34,211,238,0.15);
        }

        .badge-soft {
            background: rgba(255,255,255,0.05);
            color: var(--text-secondary);
            border: 1px solid var(--border-default);
        }

        .badge-glow {
            background: linear-gradient(120deg, rgba(34,211,238,0.2), rgba(249,115,22,0.2));
            color: #fff;
            border: 1px solid rgba(255,255,255,0.18);
        }

        .pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            border-radius: 999px;
            border: 1px solid var(--border-default);
            background: rgba(255,255,255,0.04);
            color: var(--text-secondary);
        }

        .stat-chip {
            padding: 12px 14px;
            border-radius: 16px;
            background: linear-gradient(145deg, rgba(34,211,238,0.1), rgba(255,255,255,0.02));
            border: 1px solid var(--border-default);
            box-shadow: 0 10px 30px rgba(0,0,0,0.4);
        }

        .hover-shadow:hover {
            background: var(--interactive-hover);
            border-color: var(--interactive-focus) !important;
            box-shadow: 0 12px 35px rgba(34,211,238,0.1);
        }

        .gradient-text {
            background: linear-gradient(110deg, var(--accent-primary), var(--accent-secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .fade-rise {
            opacity: 0;
            transform: translateY(12px);
            transition: all 0.6s ease;
        }

        .fade-rise.in-view {
            opacity: 1;
            transform: translateY(0);
        }

        .hero-surface {
            background: linear-gradient(135deg, rgba(34,211,238,0.08), rgba(17,24,39,0.9));
            border: 1px solid var(--border-strong);
            box-shadow: var(--glow-strong);
        }

        .accent-bar {
            width: 52px;
            height: 4px;
            border-radius: 999px;
            background: linear-gradient(120deg, var(--accent-primary), var(--accent-secondary));
        }

        .divider-dash {
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
        }

        .table {
            --bs-table-bg: rgba(9, 10, 18, 0.9);
            --bs-table-border-color: var(--border-default);
        }

        footer {
            color: var(--text-secondary);
        }
    </style>
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm">
        <div class="container py-2">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">
                <span class="gradient-text">IQInsight</span>
            </a>
            <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('quizzes.*') ? 'active' : '' }}" href="{{ route('quizzes.index') }}">Play</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('leaderboard') ? 'active' : '' }}" href="{{ route('leaderboard') }}">Leaderboard</a></li>
                    @auth
                        @if(auth()->user()->is_admin)
                            <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.index') ? 'active' : '' }}" href="{{ route('admin.index') }}">Admin</a></li>
                        @endif
                    @endauth
                </ul>
                <div class="d-flex gap-2">
                    @auth
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge rounded-pill text-bg-dark border border-secondary px-3">{{ auth()->user()->name }}</span>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="btn btn-outline-light btn-sm">Logout</button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">Login</a>
                        <a href="{{ route('register') }}" class="btn btn-accent btn-sm px-3">Sign up</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="container py-4">
        @if (session('status'))
            <div class="alert alert-success glass border-0 fade-rise in-view">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger glass border-0 fade-rise in-view">
                <strong>Heads up:</strong>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="container py-4 border-top border-dark">
        <div class="d-flex justify-content-between align-items-center">
            <div>&copy; {{ now()->year }} IQInsight. Train sharper, faster.</div>
            <div class="small text-secondary">Built with Laravel + Bootstrap.</div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) entry.target.classList.add('in-view');
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.fade-rise').forEach(el => observer.observe(el));
    </script>
    @stack('scripts')
</body>
</html>
