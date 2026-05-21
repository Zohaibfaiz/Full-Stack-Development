<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Import Movies - Admin</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #0f0f0f;
            color: #ffffff;
            font-family: 'Outfit', sans-serif;
            min-height: 100vh;
        }

        /* --- Search Bar Styling --- */
        .search-container {
            background-color: #1a1a1a;
            padding: 2rem;
            border-radius: 16px;
            border: 1px solid rgba(255,255,255,0.05);
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            margin-bottom: 3rem;
        }

        .form-control-dark {
            background-color: #0f0f0f;
            border: 1px solid rgba(255,255,255,0.1);
            color: white;
            padding: 0.8rem 1.2rem;
            border-radius: 8px;
            font-size: 1.1rem;
        }
        
        .form-control-dark:focus {
            background-color: #0f0f0f;
            color: white;
            border-color: #dc3545; /* Red Accent */
            box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25);
        }

        .form-control-dark::placeholder {
            color: #6c757d;
        }

        /* --- Movie Card Styling --- */
        .import-card {
            background-color: #1a1a1a;
            border: none;
            border-radius: 12px;
            overflow: hidden;
            height: 100%;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .import-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.4);
        }

        .poster-wrapper {
            position: relative;
            aspect-ratio: 2/3;
            overflow: hidden;
            background-color: #2c2c2c;
        }

        .poster-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .card-body {
            padding: 1.25rem;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .movie-title {
            font-weight: 700;
            margin-bottom: 0.5rem;
            line-height: 1.2;
        }

        .movie-year {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }

        .btn-import {
            margin-top: auto; /* Push to bottom */
            background-color: rgba(25, 135, 84, 0.1);
            color: #198754;
            border: 1px solid #198754;
            font-weight: 600;
            transition: all 0.2s;
        }

        .btn-import:hover {
            background-color: #198754;
            color: white;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-dark bg-black border-bottom border-secondary py-3 mb-4" style="border-color: rgba(255,255,255,0.1) !important;">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('admin.dashboard') }}">
            MOVIE<span class="text-danger">ADMIN</span>
        </a>
        <a href="{{ route('admin.movies.index') }}" class="btn btn-sm btn-outline-light rounded-pill">
            &larr; Back to Library
        </a>
    </div>
</nav>

<div class="container">

    <div class="search-container">
        <h2 class="fw-bold mb-3">Import from TMDB</h2>
        <p class="text-secondary mb-4">Search the global database to add new movies to your cinema.</p>
        
        <form action="{{ route('admin.movies.search') }}" method="GET" class="row g-3">
            <div class="col-md-10">
                <input type="text" name="query" class="form-control form-control-dark" placeholder="Enter movie title (e.g. Interstellar)" value="{{ request('query') }}" autofocus>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-danger w-100 h-100 fw-bold d-flex align-items-center justify-content-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                    </svg>
                    Search
                </button>
            </div>
        </form>
    </div>

    @if(isset($results) && count($results) > 0)
        <h4 class="mb-4 fw-bold">Search Results</h4>
        <div class="row g-4 mb-5">
            @foreach($results as $movie)
                <div class="col-6 col-md-3">
                    <div class="import-card">
                        
                        <div class="poster-wrapper">
                            @if(isset($movie['poster_path']))
                                <img src="https://image.tmdb.org/t/p/w500{{ $movie['poster_path'] }}" alt="Poster">
                            @else
                                <div class="d-flex align-items-center justify-content-center h-100 text-muted">
                                    No Poster
                                </div>
                            @endif
                        </div>

                        <div class="card-body">
                            <div class="movie-title text-truncate" title="{{ $movie['title'] }}">
                                {{ $movie['title'] }}
                            </div>
                            <div class="movie-year">
                                {{ isset($movie['release_date']) ? substr($movie['release_date'], 0, 4) : 'Unknown' }}
                            </div>

                            <form action="{{ route('admin.movies.import') }}" method="POST">
                                @csrf
                                <input type="hidden" name="tmdb_id" value="{{ $movie['id'] }}">
                                <button type="submit" class="btn btn-import w-100">
                                    + Import Movie
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>
    @elseif(request('query'))
        <div class="text-center py-5">
            <h4 class="text-secondary">No results found for "{{ request('query') }}"</h4>
            <p class="text-muted">Try checking the spelling or searching for a different title.</p>
        </div>
    @endif

</div>

</body>
</html>