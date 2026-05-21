<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'MovieBooker') }}</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        /* --- Global Styles --- */
        body {
            background-color: #0f0f0f; /* Deep Rich Black */
            color: #ffffff;
            font-family: 'Outfit', sans-serif;
            min-height: 100vh;
        }

        /* --- Glass Navbar --- */
        .navbar-custom {
            background-color: rgba(0, 0, 0, 0.85); /* Semi-transparent */
            backdrop-filter: blur(12px); /* Blur effect */
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            padding: 1rem 0;
        }
        
        .brand-text {
            letter-spacing: 1px;
            font-weight: 800;
        }

        .btn-custom-outline {
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            border-radius: 50px;
            padding: 0.4rem 1.2rem;
            transition: all 0.3s;
        }
        .btn-custom-outline:hover {
            background-color: white;
            color: black;
            border-color: white;
        }

        /* --- Movie Cards (The Polish) --- */
        .movie-card {
            background-color: #1a1a1a; /* Slightly lighter than body */
            border: none;
            border-radius: 12px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
            position: relative;
        }

        /* Hover Effect: Lift and Red Glow */
        .movie-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(220, 53, 69, 0.15); /* Red Bootstrap color glow */
            cursor: pointer;
        }

        .poster-wrapper {
            position: relative;
            overflow: hidden;
            aspect-ratio: 2/3; /* Enforce standard poster ratio */
        }

        .poster-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        /* Zoom image slightly on hover */
        .movie-card:hover .poster-wrapper img {
            transform: scale(1.05);
        }

        .card-body {
            padding: 1.25rem;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }

        .card-title {
            font-weight: 700;
            font-size: 1.1rem;
            margin-bottom: 0.2rem;
        }

        .card-meta {
            color: #adb5bd; /* Bootstrap gray-500 */
            font-size: 0.9rem;
            font-weight: 400;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        /* Optional: Empty State Styling */
        .empty-state {
            background: rgba(255,255,255,0.05);
            border: 1px dashed rgba(255,255,255,0.1);
            border-radius: 12px;
            padding: 3rem;
            text-align: center;
            color: #6c757d;
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

    <div class="container py-5">
        
        <div class="d-flex align-items-end justify-content-between mb-4 border-bottom border-secondary pb-3" style="border-color: rgba(255,255,255,0.1) !important;">
            <div>
                <h2 class="fw-bold mb-0">Now Showing</h2>
                <small class="text-secondary">Discover the latest blockbusters</small>
            </div>
        </div>
        
        @if($movies->isEmpty())
            <div class="empty-state">
                <h4>No movies scheduled</h4>
                <p>We are updating our list. Please check back later.</p>
            </div>
        @else
            <div class="row g-4">
                @foreach($movies as $movie)
                <div class="col-6 col-md-4 col-lg-3">
                    <a href="{{ route('movies.show', $movie->id) }}" class="text-decoration-none text-white">
                        <div class="movie-card h-100">
                            
                            <div class="poster-wrapper">
                                <img src="{{ $movie->poster_path }}" alt="{{ $movie->title }}">
                            </div>

                            <div class="card-body">
                                <h5 class="card-title text-truncate">{{ $movie->title }}</h5>
                                <div class="card-meta">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-clock" viewBox="0 0 16 16">
                                        <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
                                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z"/>
                                    </svg>
                                    {{ $movie->duration_minutes }} mins
                                </div>
                            </div>

                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        @endif

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>