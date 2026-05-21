<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule Movie - Admin</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #0f0f0f;
            color: #ffffff;
            font-family: 'Outfit', sans-serif;
            min-height: 100vh;
        }

        /* --- Form Container --- */
        .form-container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #1a1a1a;
            border-radius: 16px;
            padding: 2.5rem;
            border: 1px solid rgba(255,255,255,0.05);
            box-shadow: 0 15px 40px rgba(0,0,0,0.5);
        }

        /* --- Typography --- */
        .page-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        .cinema-badge {
            background-color: rgba(255, 193, 7, 0.1);
            color: #ffc107;
            border: 1px solid rgba(255, 193, 7, 0.2);
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            display: inline-block;
            margin-bottom: 2rem;
        }

        /* --- Inputs --- */
        .form-label {
            font-weight: 600;
            color: #adb5bd;
            font-size: 0.85rem;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-control-dark, .form-select-dark {
            background-color: #0f0f0f;
            border: 1px solid rgba(255,255,255,0.1);
            color: white;
            padding: 0.8rem 1rem;
            border-radius: 8px;
            font-size: 1rem;
        }

        .form-control-dark:focus, .form-select-dark:focus {
            background-color: #0f0f0f;
            color: white;
            border-color: #ffc107; /* Amber Focus */
            box-shadow: 0 0 0 0.25rem rgba(255, 193, 7, 0.25);
        }

        /* --- Pricing Card --- */
        .pricing-section {
            background-color: #141414;
            border-radius: 12px;
            padding: 1.5rem;
            border: 1px dashed rgba(255,255,255,0.1);
            margin-top: 2rem;
        }
        
        .input-group-text-dark {
            background-color: #252525;
            border-color: rgba(255,255,255,0.1);
            color: #adb5bd;
        }

        /* --- Buttons --- */
        .btn-publish {
            background-color: #ffc107;
            color: #000;
            border: none;
            padding: 1rem 2rem;
            border-radius: 8px;
            font-weight: 700;
            transition: all 0.2s;
            width: 100%;
            margin-top: 2rem;
        }
        .btn-publish:hover {
            background-color: #ffcd39;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 193, 7, 0.3);
        }

        .btn-back {
            color: #adb5bd;
            text-decoration: none;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: color 0.2s;
        }
        .btn-back:hover {
            color: white;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-dark bg-black border-bottom border-secondary py-3 mb-5" style="border-color: rgba(255,255,255,0.1) !important;">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('admin.dashboard') }}">
            MOVIE<span class="text-danger">ADMIN</span>
        </a>
    </div>
</nav>

<div class="container pb-5">

    <div class="d-flex justify-content-between align-items-center mb-4" style="max-width: 800px; margin: 0 auto;">
        <span class="text-secondary small">Programming</span>
        <a href="{{ route('admin.cinemas.index') }}" class="btn-back">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
            </svg>
            Cancel
        </a>
    </div>

    <div class="form-container">
        
        <div class="text-center">
            <h1 class="page-title">Schedule Movie</h1>
            <div class="cinema-badge">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-geo-alt-fill me-1" viewBox="0 0 16 16">
                    <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                </svg>
                {{ $cinema->name }}
            </div>
        </div>

        <form action="{{ route('admin.showtimes.store', $cinema->id) }}" method="POST">
            @csrf
            
            <div class="row g-4">
                <div class="col-md-12">
                    <label class="form-label">Select Movie</label>
                    <select name="movie_id" class="form-select form-select-dark" required>
                        <option value="" disabled selected>Choose a movie...</option>
                        @foreach($movies as $movie)
                            <option value="{{ $movie->id }}">
                                {{ $movie->title }} ({{ $movie->duration_minutes }} min)
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Select Screen</label>
                    <select name="screen_id" class="form-select form-select-dark" required>
                        <option value="" disabled selected>Choose a hall...</option>
                        @foreach($screens as $screen)
                            <option value="{{ $screen->id }}">
                                {{ $screen->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Start Date & Time</label>
                    <input type="datetime-local" name="start_time" class="form-control form-control-dark" required>
                </div>
            </div>

            <div class="pricing-section">
                <h5 class="fw-bold mb-3 text-white">Ticket Pricing</h5>
                <p class="text-secondary small mb-4">Set the price for each seat category for this specific showtime.</p>
                
                <div class="row g-3">
                    @foreach($seatTypes as $type)
                        <div class="col-md-4">
                            <label class="form-label text-secondary" style="font-size: 0.75rem;">{{ $type->name }}</label>
                            <div class="input-group">
                                <span class="input-group-text input-group-text-dark">$</span>
                                <input type="number" step="0.01" name="prices[{{ $type->id }}]" class="form-control form-control-dark" placeholder="0.00" required>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <button type="submit" class="btn btn-publish">
                Publish Schedule
            </button>

        </form>
    </div>

</div>

</body>
</html>