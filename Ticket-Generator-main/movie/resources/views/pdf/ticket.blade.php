<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Movie Ticket</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .ticket-container {
            max-width: 700px;
            margin: 0 auto;
            background-color: #ffffff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            overflow: hidden;
        }
        
        /* Header */
        .header {
            background-color: #000000;
            color: #ffffff;
            padding: 20px;
            text-align: center;
            border-bottom: 6px solid #dc3545; /* Red accent */
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            text-transform: uppercase;
            letter-spacing: 4px;
        }
        .header p {
            margin: 5px 0 0;
            font-size: 10px;
            color: #cccccc;
        }

        /* Content Body */
        .content {
            padding: 30px;
        }
        .movie-title {
            font-size: 28px;
            font-weight: bold;
            color: #000;
            margin-bottom: 5px;
            text-transform: uppercase;
            line-height: 1.2;
        }
        .cinema-info {
            font-size: 14px;
            color: #777;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        /* Layout Tables (PDF Safe) */
        .info-table {
            width: 100%;
            border-collapse: collapse;
        }
        .info-table td {
            vertical-align: top;
            padding-bottom: 20px;
        }
        
        .label {
            display: block;
            font-size: 9px;
            text-transform: uppercase;
            color: #aaa;
            font-weight: bold;
            margin-bottom: 4px;
            letter-spacing: 1px;
        }
        .value {
            font-size: 16px;
            font-weight: bold;
            color: #333;
        }
        .highlight {
            color: #dc3545; /* Red Text */
            font-size: 18px;
        }

        /* QR Section */
        .qr-section {
            background-color: #f8f9fa;
            border-top: 2px dashed #cccccc;
            padding: 20px;
            text-align: center;
        }
        .qr-img {
            display: block;
            margin: 0 auto;
            border: 4px solid #fff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .ref-code {
            font-family: 'Courier New', monospace;
            font-size: 14px;
            margin-top: 10px;
            font-weight: bold;
            letter-spacing: 2px;
        }

        /* Footer */
        .footer {
            background-color: #222;
            color: #777;
            font-size: 10px;
            text-align: center;
            padding: 10px;
        }
    </style>
</head>
<body>

    <div class="ticket-container">
        <div class="header">
            <h1>Admit One</h1>
            <p>ORDER ID: {{ $booking->booking_reference }}</p>
        </div>

        <div class="content">
            <div class="movie-title">{{ $booking->showtime->movie->title }}</div>
            <div class="cinema-info">
                {{ $booking->showtime->screen->cinema->name }} | {{ $booking->showtime->screen->name }}
            </div>

            <table class="info-table">
                <tr>
                    <td width="33%">
                        <span class="label">Date</span>
                        <span class="value">{{ \Carbon\Carbon::parse($booking->showtime->start_time)->format('M d, Y') }}</span>
                    </td>
                    <td width="33%">
                        <span class="label">Time</span>
                        <span class="value">{{ \Carbon\Carbon::parse($booking->showtime->start_time)->format('h:i A') }}</span>
                    </td>
                    <td width="33%">
                        <span class="label">Duration</span>
                        <span class="value">{{ $booking->showtime->movie->duration_minutes }} Mins</span>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <span class="label">Assigned Seats</span>
                        <span class="value highlight">
                            @foreach($booking->tickets as $ticket)
                                {{ $ticket->seat->row }}{{ $ticket->seat->number }}@if(!$loop->last), @endif
                            @endforeach
                        </span>
                    </td>
                    <td>
                        <span class="label">Total Paid</span>
                        <span class="value">${{ number_format($booking->total_amount, 2) }}</span>
                    </td>
                </tr>
            </table>
        </div>

        <div class="qr-section">
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ $booking->booking_reference }}" 
                 width="120" height="120" class="qr-img" alt="QR Code">
            
            <div class="ref-code">{{ $booking->booking_reference }}</div>
            <p style="font-size: 11px; color: #999; margin-top: 5px;">Please present this code at the cinema entrance.</p>
        </div>

        <div class="footer">
            Thank you for using MovieBooker. Enjoy the show!
        </div>
    </div>

</body>
</html>