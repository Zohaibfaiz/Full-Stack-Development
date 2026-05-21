<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Screen - Admin</title>
    
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
            max-width: 600px;
            margin: 0 auto;
            background-color: #1a1a1a;
            border-radius: 16px;
            padding: 2.5rem;
            border: 1px solid rgba(255,255,255,0.05);
            box-shadow: 0 15px 40px rgba(0,0,0,0.5);
        }

        /* --- Typography --- */
        .cinema-label {
            color: #adb5bd;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }
        
        .cinema-name {
            font-size: 2rem;
            font-weight: 700;
            color: white;
            margin-bottom: 2rem;
        }

        /* --- Inputs --- */
        .form-label {
            font-weight: 600;
            color: #adb5bd;
            font-size: 0.85rem;
            margin-bottom: 0.5rem;
        }

        .form-control-dark {
            background-color: #0f0f0f;
            border: 1px solid rgba(255,255,255,0.1);
            color: white;
            padding: 0.8rem 1rem;
            border-radius: 8px;
            font-size: 1rem;
        }

        .form-control-dark:focus {
            background-color: #0f0f0f;
            color: white;
            border-color: #0dcaf0; /* Cyan Focus for Screens */
            box-shadow: 0 0 0 0.25rem rgba(13, 202, 240, 0.25);
        }

        .form-control-dark::placeholder {
            color: #495057;
        }

        /* --- Button --- */
        .btn-generate {
            background-color: #0dcaf0;
            color: #000;
            border: none;
            padding: 0.8rem 2rem;
            border-radius: 8px;
            font-weight: 700;
            transition: all 0.2s;
            width: 100%;
        }
        .btn-generate:hover {
            background-color: #3dd5f3;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(13, 202, 240, 0.3);
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

    <div class="d-flex justify-content-between align-items-center mb-4" style="max-width: 600px; margin: 0 auto;">
        <span class="text-secondary small">Configuration</span>
        <a href="{{ route('admin.cinemas.index') }}" class="btn-back">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
            </svg>
            Cancel
        </a>
    </div>

    <div class="form-container">
        
        <div class="text-center">
            <div class="cinema-label">Adding Screen To</div>
            <h1 class="cinema-name">{{ $cinema->name }}</h1>
        </div>

        <form action="{{ route('admin.screens.store', $cinema->id) }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label class="form-label">Screen Name</label>
                <input type="text" name="name" class="form-control form-control-dark" placeholder="e.g. IMAX Hall 1" required autofocus>
            </div>

            <div class="row g-4 mb-5">
                <div class="col-6">
                    <label class="form-label">Total Rows</label>
                    <input type="number" name="rows" class="form-control form-control-dark" value="10" min="1" max="26" required>
                    <div class="form-text text-secondary small mt-1">Labeled A to Z (Max 26)</div>
                </div>

                <div class="col-6">
                    <label class="form-label">Seats per Row</label>
                    <input type="number" name="cols" class="form-control form-control-dark" value="12" min="1" max="50" required>
                    <div class="form-text text-secondary small mt-1">Total seats in one line</div>
                </div>
            </div>

            <div class="alert alert-dark border-0 bg-black text-secondary small d-flex align-items-center mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle me-2" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                    <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                </svg>
                This will automatically generate the seat map layout.
            </div>

            <button type="submit" class="btn btn-generate">
                Generate Screen Layout
            </button>

        </form>
    </div>

</div>

</body>
</html>