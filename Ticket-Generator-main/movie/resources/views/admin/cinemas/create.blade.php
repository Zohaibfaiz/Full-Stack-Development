<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Cinema - Admin</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #0f0f0f;
            color: #ffffff;
            font-family: 'Outfit', sans-serif;
            min-height: 100vh;
        }

        /* --- Form Card Styling --- */
        .form-container {
            max-width: 700px;
            margin: 0 auto;
            background-color: #1a1a1a;
            border-radius: 16px;
            padding: 2.5rem;
            border: 1px solid rgba(255,255,255,0.05);
            box-shadow: 0 15px 40px rgba(0,0,0,0.5);
        }

        /* --- Dark Inputs --- */
        .form-label {
            font-weight: 600;
            color: #adb5bd;
            font-size: 0.9rem;
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
            border-color: #198754; /* Success Green Focus */
            box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.25);
        }

        .form-control-dark::placeholder {
            color: #495057;
        }

        /* --- Buttons --- */
        .btn-save {
            background-color: #198754;
            color: white;
            border: none;
            padding: 0.8rem 2rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.2s;
            width: 100%;
        }
        .btn-save:hover {
            background-color: #157347;
            transform: translateY(-2px);
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

    <div class="d-flex justify-content-between align-items-center mb-4" style="max-width: 700px; margin: 0 auto;">
        <h2 class="fw-bold m-0">Add New Cinema</h2>
        <a href="{{ route('admin.cinemas.index') }}" class="btn-back">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
            </svg>
            Back to List
        </a>
    </div>

    <div class="form-container">
        <form action="{{ route('admin.cinemas.store') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label class="form-label">Cinema Name</label>
                <input type="text" name="name" class="form-control form-control-dark" placeholder="e.g. Grand Cinema Plex" required autofocus>
                <div class="form-text text-secondary small mt-1">Visible name for customers</div>
            </div>

            <div class="mb-4">
                <label class="form-label">City</label>
                <select name="city_id" class="form-select form-select-dark" required>
                    <option value="" disabled selected>Select a city...</option>
                    @foreach($cities as $city)
                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-5">
                <label class="form-label">Full Address</label>
                <textarea name="location" class="form-control form-control-dark" rows="3" placeholder="Street address, Area, Postal Code" required></textarea>
            </div>

            <button type="submit" class="btn btn-save">
                Create Cinema
            </button>
        </form>
    </div>

</div>

</body>
</html>