<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings - MovieBooker</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #0f0f0f;
            color: #ffffff;
            font-family: 'Outfit', sans-serif;
            min-height: 100vh;
        }
        /* Add this below your existing .btn-action styles */

.btn-cancel {
    background-color: rgba(220, 53, 69, 0.1); /* Red tint */
    color: #dc3545; /* Bootstrap Red */
    border: 1px solid transparent;
}

.btn-cancel:hover {
    background-color: #dc3545;
    color: white;
    border-color: #dc3545;
}


        /* --- Navbar --- */
        .navbar-custom {
            background-color: #000;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            padding: 1rem 0;
        }

        /* --- Page Header --- */
        .page-header {
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* --- Booking Card (Table Container) --- */
        .booking-container {
            background-color: #1a1a1a;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            border: 1px solid rgba(255,255,255,0.05);
        }

        /* --- Table Styling --- */
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

        .table-custom tbody tr:last-child {
            border-bottom: none;
        }

        .table-custom td {
            padding: 1.2rem 1.5rem;
            border: none;
        }

        /* --- Elements --- */
        .movie-icon {
            width: 45px;
            height: 45px;
            background-color: rgba(13, 202, 240, 0.1); /* Cyan Tint */
            color: #0dcaf0;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.2rem;
            margin-right: 1rem;
        }

        .seat-badge {
            background-color: #333;
            color: #fff;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.75rem;
            border: 1px solid rgba(255,255,255,0.1);
            display: inline-block;
            margin: 2px;
        }

        .btn-action {
            text-decoration: none;
            font-weight: 600;
            font-size: 0.85rem;
            padding: 0.4rem 1rem;
            border-radius: 6px;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .btn-view { color: #0dcaf0; background: rgba(13, 202, 240, 0.1); }
        .btn-view:hover { background: #0dcaf0; color: #000; }

        .btn-pdf { color: #adb5bd; background: #333; }
        .btn-pdf:hover { background: #fff; color: #000; }

        /* --- Empty State --- */
        .empty-state {
            padding: 5rem 2rem;
            text-center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .empty-icon {
            width: 80px;
            height: 80px;
            background-color: rgba(255,255,255,0.05);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
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
    
    <div class="page-header">
        <div>
            <h2 class="fw-bold m-0">My Bookings</h2>
            <p class="text-secondary mb-0 text-sm">Manage your tickets and history.</p>
        </div>
        <a href="/" class="btn btn-primary rounded-pill px-4 fw-bold">Browse Movies</a>
    </div>

    <div class="booking-container">
        @if($bookings->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-ticket-perforated" viewBox="0 0 16 16">
                        <path d="M4 4.85v.9h1v-.9H4Zm7 0v.9h1v-.9h-1Zm-7 9.8v-.9h1v.9H4Zm7 0v-.9h1v.9h-1Zm-7.48-6a.5.5 0 0 0-.52.038l-2.75 4.125a.5.5 0 0 0 0 .554l2.75 4.125a.5.5 0 0 0 .788-.554L1.65 12 4.02 9.07a.5.5 0 0 0-.5-.957Zm11.96 0a.5.5 0 0 0-.52.038l-2.75 4.125a.5.5 0 0 0 0 .554l2.75 4.125a.5.5 0 0 0 .788-.554L13.35 12 15.72 9.07a.5.5 0 0 0-.5-.957ZM1.5 3A1.5 1.5 0 0 0 0 4.5V6a.5.5 0 0 0 .5.5 1.5 1.5 0 1 1 0 3 .5.5 0 0 0-.5.5v1.5A1.5 1.5 0 0 0 1.5 13.5h13A1.5 1.5 0 0 0 16 12V9.5a.5.5 0 0 0-.5-.5 1.5 1.5 0 1 1 0-3 .5.5 0 0 0 .5-.5V4.5A1.5 1.5 0 0 0 14.5 3h-13ZM1 4.5a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 .5.5v1.05a2.5 2.5 0 0 0 0 4.9V12a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-1.5a2.5 2.5 0 0 0 0-4.9V4.5Z"/>
                    </svg>
                </div>
                <h4 class="text-white fw-bold">No bookings found</h4>
                <p class="text-secondary mb-4">You haven't purchased any tickets yet.</p>
                <a href="/" class="btn btn-outline-light rounded-pill px-4">Find a Movie</a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table-custom">
                    <thead>
                        <tr>
                            <th>Movie Details</th>
                            <th>Cinema Location</th>
                            <th>Seats</th>
                            <th>Total Paid</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                   <tbody>
    @foreach($bookings as $booking)
    <tr>
        <td>
            <div class="d-flex align-items-center">
                <div class="movie-icon">
                    {{ substr($booking->showtime->movie->title, 0, 1) }}
                </div>
                <div>
                    <div class="fw-bold text-white fs-5">{{ $booking->showtime->movie->title }}</div>
                    <div class="text-secondary small">
                        {{ \Carbon\Carbon::parse($booking->showtime->start_time)->format('M d, Y • h:i A') }}
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="fw-bold text-white">{{ $booking->showtime->screen->cinema->name }}</div>
            <div class="text-secondary small">{{ $booking->showtime->screen->name }}</div>
        </td>

        <td>
            <div style="max-width: 200px;">
                @foreach($booking->tickets as $ticket)
                    <span class="seat-badge">{{ $ticket->seat->row }}{{ $ticket->seat->number }}</span>
                @endforeach
            </div>
        </td>

        <td class="fw-bold text-white">
            ${{ number_format($booking->total_amount, 2) }}
        </td>

        <td class="text-end">
            <div class="d-flex justify-content-end align-items-center gap-2">
                
                <a href="{{ route('booking.success', $booking->id) }}" class="btn-action btn-view" title="View Ticket">
                    View
                </a>

                <a href="{{ route('booking.download', $booking->id) }}" class="btn-action btn-pdf" title="Download PDF">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                        <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                        <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/>
                    </svg>
                </a>

                @if(\Carbon\Carbon::parse($booking->showtime->start_time)->isFuture())
                    <form action="{{ route('booking.cancel', $booking->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-action btn-cancel" onclick="return confirm('Are you sure you want to cancel this booking? This action cannot be undone.');" title="Cancel Booking">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/>
                            </svg>
                        </button>
                    </form>
                @endif

            </div>
        </td>
    </tr>
    @endforeach
</tbody>
                </table>
            </div>
        @endif
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>