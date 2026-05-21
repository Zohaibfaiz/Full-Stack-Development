<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Cinemas - Admin</title>
    
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

        /* --- Table Container --- */
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
            vertical-align: middle;
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

        .table-custom td {
            padding: 1.2rem 1.5rem;
            border: none;
        }

        /* --- Action Buttons --- */
        .action-btn {
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 500;
            padding: 0.4rem 0.8rem;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s;
            border: 1px solid transparent;
        }

        /* Add Screen (Blue/Cyan) */
        .btn-screen {
            background-color: rgba(13, 202, 240, 0.1);
            color: #0dcaf0;
            border-color: rgba(13, 202, 240, 0.2);
        }
        .btn-screen:hover {
            background-color: #0dcaf0;
            color: black;
        }

        /* Schedule Movie (Orange/Warning) */
        .btn-schedule {
            background-color: rgba(255, 193, 7, 0.1);
            color: #ffc107;
            border-color: rgba(255, 193, 7, 0.2);
        }
        .btn-schedule:hover {
            background-color: #ffc107;
            color: black;
        }

        /* Add New Cinema (Green) */
        .btn-add {
            background-color: #198754;
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
            background-color: #157347;
            transform: translateY(-2px);
            color: white;
        }

        /* Location Badge */
        .city-badge {
            background-color: #333;
            color: #fff;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
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
            <h2 class="fw-bold mb-1">Cinemas & Theaters</h2>
            <p class="text-secondary mb-0 text-sm">Manage locations, screens, and showtimes.</p>
        </div>
        <a href="{{ route('admin.cinemas.create') }}" class="btn-add shadow-lg">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-building-add" viewBox="0 0 16 16">
                <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0Z"/>
                <path d="M2 1a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v6.5a.5.5 0 0 1-1 0V1H3v14h3v-2.5a.5.5 0 0 1 .5-.5H8v4H3a1 1 0 0 1-1-1V1Z"/>
            </svg>
            Add New Cinema
        </a>
    </div>

    <div class="table-container">
        @if($cinemas->isEmpty())
            <div class="empty-state">
                <h4 class="fw-bold text-white mb-2">No Cinemas Found</h4>
                <p>Create your first cinema location to get started.</p>
            </div>
        @else
            <table class="table-custom">
                <thead>
                    <tr>
                        <th>Cinema Name</th>
                        <th>Location Details</th>
                        <th>Quick Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cinemas as $cinema)
                    <tr>
                        <td>
                            <div class="fw-bold text-white fs-5">{{ $cinema->name }}</div>
                            <div class="small text-secondary">ID: {{ $cinema->id }}</div>
                        </td>

                        <td>
                            <div class="mb-1">
                                <span class="city-badge">{{ $cinema->city->name }}</span>
                            </div>
                            <div class="small text-secondary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-geo-alt me-1" viewBox="0 0 16 16">
                                    <path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A31.493 31.493 0 0 1 8 14.58a31.481 31.481 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94zM8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10z"/>
                                    <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4z"/>
                                </svg>
                                {{ $cinema->location }}
                            </div>
                        </td>

                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.screens.create', $cinema->id) }}" class="action-btn btn-screen">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-display" viewBox="0 0 16 16">
                                        <path d="M0 4s0-2 2-2h12s2 0 2 2v6s0 2-2 2h-4c0 .667.083 1.167.25 1.5H11a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1h.75c.167-.333.25-.833.25-1.5H2s-2 0-2-2V4zm1.398-.855a.758.758 0 0 0-.254.302A1.46 1.46 0 0 0 1 4.01V10c0 .325.078.502.145.537.065.034.217.05.488.05h12.734c.27 0 .423-.016.488-.05.067-.035.145-.212.145-.537V4.01a1.464 1.464 0 0 0-.145-.563.758.758 0 0 0-.254-.302C13.861 2.99 13.275 3 12.367 3H3.633c-.908 0-1.494-.01-1.878.145z"/>
                                    </svg>
                                    Screens
                                </a>

                                <a href="{{ route('admin.showtimes.create', $cinema->id) }}" class="action-btn btn-schedule">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-calendar-plus" viewBox="0 0 16 16">
                                        <path d="M8 7a.5.5 0 0 1 .5.5V9H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V10H6a.5.5 0 0 1 0-1h1.5V7.5A.5.5 0 0 1 8 7z"/>
                                        <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                                    </svg>
                                    Schedule
                                </a>
                            </div>
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