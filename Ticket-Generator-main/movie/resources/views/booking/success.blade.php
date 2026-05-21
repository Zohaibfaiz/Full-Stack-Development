<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmed - Ticket Ready</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #0f0f0f;
            color: #ffffff;
            font-family: 'Outfit', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* --- TICKET CARD DESIGN --- */
        .ticket-container {
            max-width: 400px;
            width: 100%;
            margin: 0 auto;
            animation: slideUp 0.6s ease-out;
        }

        .ticket-card {
            background-color: #1a1a1a;
            border-radius: 20px;
            overflow: hidden;
            position: relative;
            box-shadow: 0 20px 50px rgba(0,0,0,0.5);
            border: 1px solid rgba(255,255,255,0.05);
        }

        /* "Notch" effect for tear-off look */
        .ticket-notch {
            position: absolute;
            height: 30px;
            width: 30px;
            background-color: #0f0f0f; /* Matches body bg */
            border-radius: 50%;
            top: 72%; /* Adjust based on where you want the split */
            z-index: 2;
        }
        .notch-left { left: -15px; }
        .notch-right { right: -15px; }

        /* Dashed Divider */
        .ticket-divider {
            border-top: 2px dashed rgba(255,255,255,0.1);
            margin: 2rem 0;
            position: relative;
        }

        /* --- HEADER & SUCCESS ICON --- */
        .success-icon-wrapper {
            width: 80px;
            height: 80px;
            background: rgba(25, 135, 84, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
        }
        .success-icon {
            font-size: 2.5rem;
            color: #198754; /* Success Green */
        }

        /* --- TYPOGRAPHY --- */
        .movie-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.2rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-label {
            color: #6c757d;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 4px;
        }

        .info-value {
            font-size: 1.1rem;
            font-weight: 600;
        }

        .seat-badge {
            background-color: #2b3035;
            color: #fff;
            border: 1px solid rgba(255,255,255,0.1);
            padding: 5px 10px;
            border-radius: 6px;
            font-size: 0.9rem;
            display: inline-block;
            margin: 2px;
        }

        /* --- QR CODE SECTION --- */
        .qr-section {
            background-color: #fff;
            padding: 1.5rem;
            border-radius: 12px;
            display: inline-block;
        }

        /* --- ANIMATION --- */
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

<div class="container py-5">
    
    <div class="text-center mb-5">
        <div class="success-icon-wrapper">
            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-check-lg success-icon" viewBox="0 0 16 16">
                <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/>
            </svg>
        </div>
        <h2 class="fw-bold text-white">Booking Confirmed!</h2>
        <p class="text-secondary">Your tickets are ready.</p>
    </div>

    <div class="ticket-container">
        <div class="ticket-card">
            
            <div class="ticket-notch notch-left"></div>
            <div class="ticket-notch notch-right"></div>

            <div class="card-body p-4 p-md-5">
                
                <div class="text-center mb-4">
                    <p class="info-label mb-1">MOVIE TICKET</p>
                    <h3 class="movie-title">{{ $booking->showtime->movie->title }}</h3>
                    <p class="text-secondary mb-0">{{ $booking->showtime->screen->cinema->name }}</p>
                </div>

                <div class="row text-center g-4 mb-2">
                    <div class="col-6">
                        <div class="info-label">DATE</div>
                        <div class="info-value text-danger">
                            {{ \Carbon\Carbon::parse($booking->showtime->start_time)->format('M d') }}
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="info-label">TIME</div>
                        <div class="info-value">
                            {{ \Carbon\Carbon::parse($booking->showtime->start_time)->format('h:i A') }}
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="info-label">SCREEN</div>
                        <div class="info-value">{{ $booking->showtime->screen->name }}</div>
                    </div>
                    <div class="col-6">
                        <div class="info-label">TOTAL</div>
                        <div class="info-value">${{ number_format($booking->total_amount, 2) }}</div>
                    </div>
                </div>

                <div class="ticket-divider"></div>

                <div class="text-center">
                    <div class="info-label mb-2">SEATS</div>
                    <div class="mb-4">
                        @foreach($booking->tickets as $ticket)
                            <span class="seat-badge">{{ $ticket->seat->row }}{{ $ticket->seat->number }}</span>
                        @endforeach
                    </div>

                    <div class="qr-section shadow-sm">
                        {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(120)->color(0,0,0)->generate($booking->booking_reference) !!}
                    </div>
                    <p class="mt-3 mb-0 text-secondary small font-monospace">REF: {{ $booking->booking_reference }}</p>
                </div>

            </div>
        </div>

        <div class="d-grid gap-2 mt-4">
            <a href="{{ route('booking.download', $booking->id) }}" class="btn btn-outline-light rounded-pill py-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download me-2" viewBox="0 0 16 16">
                    <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                    <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/>
                </svg>
                Download Ticket
            </a>
            
            <a href="/" class="btn btn-link text-secondary text-decoration-none">
                Back to Home
            </a>
        </div>

    </div>
</div>

</body>
</html>