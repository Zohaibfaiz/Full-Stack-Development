<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Movies - Admin</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #0f0f0f;
            color: #ffffff;
            font-family: 'Outfit', sans-serif;
            min-height: 100vh;
        }

        /* --- Page Header --- */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        /* --- Custom Table --- */
        .table-container {
            background-color: #1a1a1a;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            border: 1px solid rgba(255,255,255,0.05);
        }

        .table-custom {
            width: 100%;
            margin-bottom: 0;
            color: #adb5bd;
        }

        .table-custom thead th {
            background-color: #252525;
            color: #fff;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 1px;
            padding: 1rem 1.5rem;
            border: none;
        }

        .table-custom tbody tr {
            border-bottom: 1px solid rgba(255,255,255,0.05);
            transition: background-color 0.2s;
        }

        .table-custom tbody tr:hover {
            background-color: rgba(255,255,255,0.03);
        }

        .table-custom tbody tr:last-child {
            border-bottom: none;
        }

        .table-custom td {
            padding: 1rem 1.5rem;
            vertical-align: middle;
            border: none;
        }

        /* --- Thumbnails --- */
        .movie-thumb {
            width: 50px;
            height: 75px;
            object-fit: cover;
            border-radius: 6px;
            background-color: #333;
        }

        /* --- Buttons --- */
        .btn-add {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 0.6rem 1.5rem;
            border-radius: 50px;
            font-weight: 600;
            transition: transform 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-add:hover {
            background-color: #bb2d3b;
            transform: translateY(-2px);
            color: white;
        }

        .btn-icon {
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            border: 1px solid rgba(255,255,255,0.1);
            color: #adb5bd;
            transition: all 0.2s;
            background: transparent;
        }
        .btn-icon:hover {
            background-color: rgba(220, 53, 69, 0.1);
            color: #dc3545;
            border-color: #dc3545;
        }

        /* Empty State */
        .empty-state {
            padding: 4rem;
            text-align: center;
            color: #6c757d;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-dark bg-black border-bottom border-secondary py-3 mb-5" style="border-color: rgba(255,255,255,0.1) !important;">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('admin.dashboard') }}">
            MOVIE<span class="text-danger">ADMIN</span>
        </a>
        <a href="{{ route('home') }}" class="btn btn-sm btn-outline-light rounded-pill">View Site</a>
    </div>
</nav>

<div class="container">
    
    <div class="page-header">
        <div>
            <h2 class="fw-bold mb-1">Movies Library</h2>
            <p class="text-secondary mb-0 text-sm">Manage your cinema inventory</p>
        </div>
        <a href="{{ route('admin.movies.search') }}" class="btn-add shadow-lg">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z"/>
            </svg>
            Add Movie
        </a>
    </div>

    <div class="table-container">
        @if($movies->isEmpty())
            <div class="empty-state">
                <h4 class="fw-bold text-white mb-2">No movies found</h4>
                <p>Start by adding movies from the database.</p>
            </div>
        @else
            <table class="table-custom">
                <thead>
                    <tr>
                        <th width="80">Poster</th>
                        <th>Movie Details</th>
                        <th>Duration</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($movies as $movie)
                    <tr>
                        <td>
                            @if($movie->poster_path)
                                <img src="{{ $movie->poster_path }}" alt="Poster" class="movie-thumb">
                            @else
                                <div class="movie-thumb d-flex align-items-center justify-content-center text-muted small">N/A</div>
                            @endif
                        </td>

                        <td>
                            <div class="fw-bold text-white fs-5">{{ $movie->title }}</div>
                            <div class="small text-secondary">ID: {{ $movie->id }}</div>
                        </td>

                        <td>
                            <span class="badge bg-dark border border-secondary text-secondary rounded-pill px-3">
                                {{ $movie->duration_minutes }} min
                            </span>
                        </td>

                        <td class="text-end">
                            <form action="#" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-icon" title="Delete Movie">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                        <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z"/>
                                    </svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>

</body>
</html>