<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    
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
            margin-bottom: 2rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            padding-bottom: 1rem;
        }

        /* --- Stats Cards --- */
        .stats-card {
            background-color: #1a1a1a;
            border-radius: 16px;
            padding: 1.5rem;
            border: 1px solid rgba(255,255,255,0.05);
            height: 100%;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }

        /* Colored Accents */
        .stats-card.green { border-left: 4px solid #198754; }
        .stats-card.blue { border-left: 4px solid #0dcaf0; }
        .stats-card.purple { border-left: 4px solid #6f42c1; }

        .stats-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
        }
        
        .bg-green-soft { background-color: rgba(25, 135, 84, 0.15); color: #198754; }
        .bg-blue-soft { background-color: rgba(13, 202, 240, 0.15); color: #0dcaf0; }
        .bg-purple-soft { background-color: rgba(111, 66, 193, 0.15); color: #6f42c1; }

        .stats-label {
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.75rem;
            color: #adb5bd;
            font-weight: 600;
        }

        .stats-value {
            font-size: 2rem;
            font-weight: 700;
            color: white;
            margin-top: 0.2rem;
        }

        /* --- Quick Actions --- */
        .action-card {
            background-color: #1a1a1a;
            border-radius: 16px;
            padding: 1.5rem;
            border: 1px solid rgba(255,255,255,0.05);
            display: flex;
            align-items: center;
            gap: 1rem;
            text-decoration: none;
            transition: all 0.2s;
        }

        .action-card:hover {
            background-color: #252525;
            border-color: rgba(255,255,255,0.1);
            transform: translateY(-2px);
        }

        .action-icon {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        .bg-indigo { background-color: #6610f2; color: white; }
        .bg-pink { background-color: #d63384; color: white; }

        /* --- Recent Bookings Table --- */
        .table-container {
            background-color: #1a1a1a;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid rgba(255,255,255,0.05);
            margin-top: 2rem;
        }

        .table-header {
            padding: 1rem 1.5rem;
            background-color: #252525;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .table-custom {
            width: 100%;
            color: #adb5bd;
            vertical-align: middle;
        }

        .table-custom thead th {
            background-color: #1f1f1f;
            color: #fff;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            padding: 1rem 1.5rem;
            border: none;
        }

        .table-custom tbody tr {
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }
        .table-custom tbody tr:last-child { border-bottom: none; }
        .table-custom td { padding: 1rem 1.5rem; }

        .status-badge {
            background-color: rgba(25, 135, 84, 0.15);
            color: #198754;
            padding: 4px 10px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            font-family: monospace;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-dark bg-black border-bottom border-secondary py-3 mb-5" style="border-color: rgba(255,255,255,0.1) !important;">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#">
            MOVIE<span class="text-danger">ADMIN</span>
        </a>
        <div class="d-flex gap-3">
            <a href="/" class="btn btn-sm btn-outline-light rounded-pill">View Site</a>
            
            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-sm btn-danger rounded-pill">Log Out</button>
            </form>
        </div>
    </div>
</nav>

<div class="container pb-5">

    <div class="page-header">
        <h2 class="fw-bold m-0">Dashboard Overview</h2>
        <p class="text-secondary mb-0">Welcome back, Admin.</p>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="stats-card green">
                <div class="stats-icon bg-green-soft">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-currency-dollar" viewBox="0 0 16 16">
                        <path d="M4 10.781c.148 1.667 1.513 2.85 3.591 3.003V15h1.043v-1.216c2.27-.179 3.678-1.438 3.678-3.3 0-1.59-.947-2.51-2.956-3.028l-.722-.187V3.467c1.122.11 1.879.714 2.07 1.616h1.47c-.166-1.6-1.54-2.748-3.54-2.875V1H7.591v1.233c-1.939.23-3.27 1.472-3.27 3.156 0 1.454.966 2.483 2.661 2.917l.61.162v4.031c-1.149-.17-1.94-.8-2.131-1.718H4zm3.391-3.836c-1.043-.263-1.6-.825-1.6-1.616 0-.944.704-1.641 1.8-1.828v3.495l-.2-.05zm1.591 1.872c1.287.323 1.852.859 1.852 1.769 0 1.097-.826 1.828-2.2 1.939V8.73l.348.086z"/>
                    </svg>
                </div>
                <div class="stats-label">Total Revenue</div>
                <div class="stats-value">${{ number_format($totalRevenue, 2) }}</div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stats-card blue">
                <div class="stats-icon bg-blue-soft">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-ticket-perforated" viewBox="0 0 16 16">
                        <path d="M4 4.85v.9h1v-.9H4Zm7 0v.9h1v-.9h-1Zm-7 9.8v-.9h1v.9H4Zm7 0v-.9h1v.9h-1Zm-7.48-6a.5.5 0 0 0-.52.038l-2.75 4.125a.5.5 0 0 0 0 .554l2.75 4.125a.5.5 0 0 0 .788-.554L1.65 12 4.02 9.07a.5.5 0 0 0-.5-.957Zm11.96 0a.5.5 0 0 0-.52.038l-2.75 4.125a.5.5 0 0 0 0 .554l2.75 4.125a.5.5 0 0 0 .788-.554L13.35 12 15.72 9.07a.5.5 0 0 0-.5-.957ZM1.5 3A1.5 1.5 0 0 0 0 4.5V6a.5.5 0 0 0 .5.5 1.5 1.5 0 1 1 0 3 .5.5 0 0 0-.5.5v1.5A1.5 1.5 0 0 0 1.5 13.5h13A1.5 1.5 0 0 0 16 12V9.5a.5.5 0 0 0-.5-.5 1.5 1.5 0 1 1 0-3 .5.5 0 0 0 .5-.5V4.5A1.5 1.5 0 0 0 14.5 3h-13ZM1 4.5a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 .5.5v1.05a2.5 2.5 0 0 0 0 4.9V12a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-1.5a2.5 2.5 0 0 0 0-4.9V4.5Z"/>
                    </svg>
                </div>
                <div class="stats-label">Tickets Sold</div>
                <div class="stats-value">{{ number_format($totalTickets) }}</div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stats-card purple">
                <div class="stats-icon bg-purple-soft">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                    </svg>
                </div>
                <div class="stats-label">Top Movie</div>
                <div class="stats-value text-truncate" title="{{ $bestMovie ? $bestMovie->title : '' }}">
                    {{ $bestMovie ? Str::limit($bestMovie->title, 15) : 'N/A' }}
                </div>
                <div class="small text-secondary mt-1">
                    {{ $bestMovie ? $bestMovie->tickets_sold . ' tickets sold' : 'No data yet' }}
                </div>
            </div>
        </div>
    </div>

    <h5 class="fw-bold mb-3">Quick Actions</h5>
    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <a href="{{ route('admin.movies.index') }}" class="action-card">
                <div class="action-icon bg-indigo">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-film" viewBox="0 0 16 16">
                        <path d="M0 1a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V1zm4 0v6h8V1H4zm8 8H4v6h8V9zM1 1v2h2V1H1zm2 3H1v2h2V4zM1 7v2h2V7H1zm2 3H1v2h2v-2zm-2 3v2h2v-2H1zM15 1h-2v2h2V1zm-2 3v2h2V4h-2zm2 3h-2v2h2V7zm-2 3v2h2v-2h-2zm2 3h-2v2h2v-2z"/>
                    </svg>
                </div>
                <div>
                    <div class="text-secondary small fw-bold text-uppercase">Inventory</div>
                    <div class="fw-bold text-white">Movies</div>
                </div>
            </a>
        </div>

        <div class="col-md-3">
            <a href="{{ route('admin.cinemas.index') }}" class="action-card">
                <div class="action-icon bg-pink">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-building" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M14.763.075A.5.5 0 0 1 15 .5v15a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5V14h-1v1.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V10a.5.5 0 0 1 .342-.474L6 7.64V4.5a.5.5 0 0 1 .276-.447l8-4a.5.5 0 0 1 .487.022zM6 8.694 1 10.36V15h5V8.694zM7 15h2v-1.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5V15h2V1.309l-7 3.5V15z"/>
                        <path d="M2 11h1v1H2v-1zm2 0h1v1H4v-1zm-2 2h1v1H2v-1zm2 0h1v1H4v-1zm4-4h1v1H8V9zm2 0h1v1h-1V9zm-2 2h1v1H8v-1zm2 0h1v1h-1v-1zm2-2h1v1h-1V9zm0 2h1v1h-1v-1zM8 7h1v1H8V7zm2 0h1v1h-1V7zm2 0h1v1h-1V7zM8 5h1v1H8V5zm2 0h1v1h-1V5zm2 0h1v1h-1V5zm0-2h1v1h-1V3z"/>
                    </svg>
                </div>
                <div>
                    <div class="text-secondary small fw-bold text-uppercase">Locations</div>
                    <div class="fw-bold text-white">Cinemas</div>
                </div>
            </a>
        </div>
    </div>

    <div class="table-container">
        <div class="table-header">
            <h5 class="fw-bold m-0">Recent Bookings</h5>
            <span class="badge bg-secondary text-white rounded-pill px-3">Latest {{ $latestBookings->count() }}</span>
        </div>

        @if($latestBookings->isEmpty())
            <div class="p-5 text-center text-secondary">
                No bookings found.
            </div>
        @else
            <div class="table-responsive">
                <table class="table-custom">
                    <thead>
                        <tr>
                            <th>Ref</th>
                            <th>Customer</th>
                            <th>Movie</th>
                            <th>Amount</th>
                            <th class="text-end">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($latestBookings as $booking)
                        <tr>
                            <td>
                                <span class="status-badge">{{ $booking->booking_reference }}</span>
                            </td>
                            <td>
                                <div class="fw-bold text-white">{{ $booking->user->name ?? 'Guest' }}</div>
                                <div class="small">{{ $booking->user->email ?? '-' }}</div>
                            </td>
                            <td>
                                {{ $booking->showtime->movie->title }}
                            </td>
                            <td class="fw-bold text-white">
                                ${{ number_format($booking->total_amount, 2) }}
                            </td>
                            <td class="text-end text-secondary small">
                                {{ $booking->created_at->diffForHumans() }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

</div>

</body>
</html>