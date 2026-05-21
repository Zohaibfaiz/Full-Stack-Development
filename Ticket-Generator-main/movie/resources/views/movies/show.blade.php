<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $movie->title }} - Book Tickets</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800&display=swap" rel="stylesheet">

    <style>
        /* --- CORE THEME --- */
        body {
            background-color: #0f0f0f;
            color: #ffffff;
            font-family: 'Outfit', sans-serif;
            overflow-x: hidden;
        }

        /* --- HERO SECTION --- */
        .movie-hero {
            position: relative;
            min-height: 70vh; /* Taller hero section */
            display: flex;
            align-items: center;
            padding-top: 80px;
            overflow: hidden;
        }

        /* 1. Backdrop (Furthest Back) */
        .hero-backdrop {
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background-size: cover;
            background-position: center top;
            filter: blur(40px) brightness(0.5); /* Darker blur */
            z-index: 0;
            transform: scale(1.1);
        }

        /* 2. Overlay (Middle) */
        .hero-overlay {
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: linear-gradient(to bottom, rgba(15,15,15,0.2) 0%, rgba(15,15,15,1) 90%);
            z-index: 1;
        }

        /* 3. Content (Front) */
        .hero-content {
            position: relative;
            z-index: 10; /* Ensures content is above backdrop */
            width: 100%;
        }

        /* --- POSTER CARD (Crucial Fixes) --- */
        .poster-card {
            border-radius: 16px;
            box-shadow: 0 25px 60px rgba(0,0,0,0.8); /* Deep shadow to separate from background */
            overflow: hidden;
            border: 1px solid rgba(255,255,255,0.15);
            background-color: #000; /* Fallback color */
            position: relative;
            z-index: 20; /* Highest priority */
            aspect-ratio: 2/3; /* Enforce poster shape */
        }
        
        .poster-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        /* --- TYPOGRAPHY & META --- */
        .movie-title {
            font-size: 3.5rem;
            font-weight: 800;
            line-height: 1.1;
            text-shadow: 0 10px 30px rgba(0,0,0,0.5);
            margin-bottom: 1rem;
        }

        .movie-meta {
            display: flex;
            align-items: center;
            gap: 15px;
            color: #adb5bd;
            font-size: 1.1rem;
            margin-bottom: 1.5rem;
        }

        .meta-pill {
            background: rgba(255,255,255,0.1);
            padding: 5px 12px;
            border-radius: 50px;
            font-size: 0.85rem;
            border: 1px solid rgba(255,255,255,0.1);
            backdrop-filter: blur(5px);
        }

        .movie-desc {
            font-size: 1.1rem;
            line-height: 1.7;
            color: #d1d5db;
            max-width: 800px;
        }

        /* --- SHOWTIMES SECTION --- */
        .showtimes-container {
            position: relative;
            z-index: 10;
            padding-bottom: 5rem;
            margin-top: -50px; /* Overlap effect */
        }

        .cinema-card {
            background-color: #1a1a1a;
            border: 1px solid rgba(255,255,255,0.05);
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            transition: transform 0.2s;
        }

        .cinema-card:hover {
            transform: translateY(-3px);
            border-color: rgba(255,255,255,0.2);
            background-color: #222;
        }

        .time-btn {
            background-color: #0f0f0f;
            border: 1px solid #333;
            color: #fff;
            padding: 0.8rem 1.5rem;
            border-radius: 8px;
            text-decoration: none;
            display: inline-flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-width: 110px;
            transition: all 0.2s;
        }

        .time-btn:hover {
            border-color: #dc3545;
            background-color: #dc3545;
            color: white;
            box-shadow: 0 0 20px rgba(220, 53, 69, 0.4);
        }
        
        .time-btn:hover .price-text { color: #fff; }

        .time-text { font-size: 1.2rem; font-weight: 700; }
        .price-text { font-size: 0.75rem; color: #adb5bd; margin-top: 2px; }

        .btn-back-custom {
            color: #adb5bd;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
            transition: color 0.2s;
            margin-bottom: 1rem;
        }
        .btn-back-custom:hover { color: #fff; }

        /* Simplified Animation (No Opacity Hiding) */
        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-up {
            animation: fadeSlideUp 0.8s ease-out forwards;
        }
    </style>
</head>
<body>

 <nav class="navbar navbar-dark bg-transparent position-absolute top-0 w-100 py-4" style="z-index: 1000;">
    <div class="container">
        <a class="navbar-brand fw-bold" href="/">
            MOVIE<span class="text-danger">BOOKER</span>
        </a>
        
        <div class="d-flex align-items-center gap-3">
            @auth
                @if(Auth::user()->is_admin)
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-danger rounded-pill px-3 fw-bold">
                        Admin Panel
                    </a>
                @else
                    <a href="{{ url('/dashboard') }}" class="btn btn-sm btn-outline-light rounded-pill px-4">
                        My Account
                    </a>
                @endif

                <div class="border-start border-secondary mx-2" style="height: 20px;"></div>

                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-sm text-secondary text-decoration-none fw-bold hover-white" style="transition: color 0.2s;">
                        Log Out
                    </button>
                </form>

            @else
                <div class="d-flex gap-2">
                    <a href="{{ route('login') }}" class="btn btn-sm btn-danger rounded-pill px-4">Sign In</a>
                    <a href="{{ route('register') }}" class="btn btn-sm btn-outline-light rounded-pill px-4">Register</a>
                </div>
            @endauth
        </div>
    </div>

    <style>
        .hover-white:hover { color: #fff !important; }
    </style>
</nav>

    <div class="movie-hero">
        
        <div class="hero-backdrop" style="background-image: url('{{ $movie->poster_path }}');"></div>
        <div class="hero-overlay"></div>

        <div class="container hero-content">
            <div class="row align-items-center">
                
                <div class="col-md-4 mb-5 mb-md-0">
                    <div class="poster-card animate-up">
                        <img src="{{ $movie->poster_path }}" alt="{{ $movie->title }}">
                    </div>
                </div>

                <div class="col-md-8 ps-md-5">
                    
                    <a href="/" class="btn-back-custom animate-up">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                        </svg>
                        Back to Movies
                    </a>

                    <h1 class="movie-title animate-up" style="animation-delay: 0.1s;">{{ $movie->title }}</h1>
                    
                    <div class="movie-meta animate-up" style="animation-delay: 0.2s;">
                        <span class="meta-pill">{{ \Carbon\Carbon::parse($movie->release_date)->format('Y') }}</span>
                        <span class="meta-pill">{{ $movie->duration_minutes }} min</span>
                        <span>Now Showing</span>
                    </div>

                    <p class="movie-desc animate-up" style="animation-delay: 0.3s;">
                        {{ $movie->overview }}
                    </p>

                </div>
            </div>
        </div>
    </div>

    <div class="container showtimes-container">
        
        @if(count($showtimes) > 0)
            <h3 class="fw-bold mb-4 text-white" style="border-left: 4px solid #dc3545; padding-left: 15px;">Available Showtimes</h3>
            
            @foreach($showtimes as $cinemaName => $times)
                <div class="cinema-card animate-up" style="animation-delay: 0.4s;">
                    <div class="d-flex align-items-center mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#dc3545" class="bi bi-geo-alt-fill me-2" viewBox="0 0 16 16">
                            <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                        </svg>
                        <h5 class="fw-bold m-0 text-white">{{ $cinemaName }}</h5>
                    </div>
                    
                    <div class="d-flex flex-wrap gap-3">
                        @foreach($times as $show)
                            <a href="{{ route('booking.index', $show->id) }}" class="time-btn">
                                <span class="time-text">{{ \Carbon\Carbon::parse($show->start_time)->format('h:i A') }}</span>
                                <span class="price-text">From ${{ number_format($show->prices->min('price'), 2) }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @else
            <div class="text-center py-5">
                <div class="text-secondary fs-4">No showtimes currently scheduled.</div>
                <p class="text-secondary">Please check back later.</p>
            </div>
        @endif

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>