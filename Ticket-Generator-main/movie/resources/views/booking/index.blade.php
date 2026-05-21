<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Seats - {{ $showtime->movie->title }}</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #0f0f0f;
            color: #ffffff;
            font-family: 'Outfit', sans-serif;
        }

        /* --- SCREEN VISUAL --- */
        .screen-container {
            perspective: 1000px;
            margin-bottom: 3rem;
            display: flex;
            justify-content: center;
        }
        .cinema-screen {
            background: linear-gradient(to bottom, rgba(255,255,255,0.8) 0%, rgba(255,255,255,0.1) 100%);
            height: 60px;
            width: 80%;
            transform: rotateX(-15deg) scale(0.9);
            box-shadow: 0 25px 40px rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            opacity: 0.8;
            position: relative;
        }
        .screen-text {
            text-align: center;
            font-size: 0.8rem;
            color: #6c757d;
            margin-top: 10px;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        /* --- SEAT GRID --- */
        .seat-grid {
            display: grid;
            gap: 12px;
            justify-content: center;
            margin: 0 auto;
        }

        /* --- SEAT STYLING --- */
        .seat {
            width: 40px;
            height: 40px;
            border-top-left-radius: 12px; /* Chair shape */
            border-top-right-radius: 12px;
            border-bottom-left-radius: 4px;
            border-bottom-right-radius: 4px;
            background-color: #2b3035; /* Dark Gray (Available) */
            border: 1px solid rgba(255,255,255,0.1);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            color: #adb5bd;
            transition: all 0.2s ease;
            position: relative;
        }

        /* Seat Armrests (Visual Trick) */
        .seat::after {
            content: '';
            position: absolute;
            bottom: 2px;
            width: 80%;
            height: 4px;
            background: rgba(0,0,0,0.3);
            border-radius: 2px;
        }

        .seat:hover:not(.taken) {
            background-color: #495057;
            transform: scale(1.1);
            color: white;
            border-color: rgba(255,255,255,0.4);
        }

        /* STATUS COLORS */
        .seat.taken {
            background-color: #381818; /* Dark Red background */
            color: #7a2e2e; /* Dim Red text */
            cursor: not-allowed;
            border-color: transparent;
        }
        
        .seat.selected {
            background-color: #198754; /* Success Green */
            color: white;
            border-color: #20c997;
            box-shadow: 0 0 15px rgba(25, 135, 84, 0.4); /* Glow */
        }

        /* --- SIDEBAR CARD --- */
        .booking-card {
            background-color: #1a1a1a;
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 16px;
            padding: 2rem;
            position: sticky;
            top: 2rem; /* Stick to top when scrolling */
        }
        
        .movie-poster-thumb {
            width: 60px;
            height: 90px;
            object-fit: cover;
            border-radius: 8px;
        }

        .price-tag {
            font-size: 2rem;
            font-weight: 700;
            color: #fff;
        }

        .legend-item {
            display: flex;
            align-items: center;
            font-size: 0.85rem;
            color: #adb5bd;
            gap: 8px;
        }
        .dot { width: 16px; height: 16px; border-radius: 4px; display: inline-block; }
    </style>
</head>
<body>

<nav class="navbar navbar-dark bg-black border-bottom border-secondary py-3" style="border-color: rgba(255,255,255,0.1) !important;">
    <div class="container">
        <a class="navbar-brand fw-bold" href="/">
            <span class="text-white">Back to </span><span class="text-danger">Movies</span>
        </a>
    </div>
</nav>

<div class="container mt-5 mb-5">
    <div class="row g-5">
        
        <div class="col-lg-8">
            <div class="d-flex flex-column align-items-center">
                
                <div class="w-100 mb-5">
                    <div class="screen-container">
                        <div class="cinema-screen"></div>
                    </div>
                    <div class="screen-text">Screen</div>
                </div>

                <div class="seat-grid" style="grid-template-columns: repeat({{ $seats->max('number') }}, 40px);">
                    @foreach($seats as $seat)
                        @php
                            $isTaken = in_array($seat->id, $bookedSeatIds);
                            $price = $prices[$seat->seat_type_id] ?? 0;
                            // Add a visual gap for aisles if needed (optional logic could go here)
                        @endphp

                        <div 
                            class="seat {{ $isTaken ? 'taken' : '' }}" 
                            data-id="{{ $seat->id }}" 
                            data-price="{{ $price }}"
                            data-name="{{ $seat->row }}{{ $seat->number }}"
                            onclick="toggleSeat(this)"
                            title="Row {{ $seat->row }} Seat {{ $seat->number }} - ${{ $price }}">
                            {{ $seat->row }}{{ $seat->number }} 
                        </div>
                    @endforeach
                </div>

                <div class="d-flex justify-content-center mt-5 gap-4">
                    <div class="legend-item">
                        <span class="dot" style="background-color: #2b3035; border: 1px solid rgba(255,255,255,0.2)"></span> 
                        Available
                    </div>
                    <div class="legend-item">
                        <span class="dot bg-success"></span> 
                        Selected
                    </div>
                    <div class="legend-item">
                        <span class="dot" style="background-color: #381818;"></span> 
                        Sold Out
                    </div>
                </div>

            </div>
        </div>

        <div class="col-lg-4">
            <div class="booking-card shadow-lg">
                
                <div class="d-flex gap-3 mb-4">
                    @if($showtime->movie->poster_path)
                        <img src="{{ $showtime->movie->poster_path }}" class="movie-poster-thumb" alt="Poster">
                    @endif
                    <div>
                        <h4 class="fw-bold mb-1">{{ $showtime->movie->title }}</h4>
                        <div class="text-secondary small">
                            {{ $showtime->screen->cinema->name }} • {{ $showtime->screen->name }}
                        </div>
                        <div class="text-danger small fw-bold mt-1">
                            {{ \Carbon\Carbon::parse($showtime->start_time)->format('D, M d • h:i A') }}
                        </div>
                    </div>
                </div>

                <hr class="border-secondary opacity-25">

                <h6 class="text-uppercase text-secondary small fw-bold mb-3">Your Seats</h6>
                <ul id="selected-seats-list" class="list-unstyled mb-4 text-light" style="min-height: 50px;">
                    <li class="text-secondary small fst-italic">Please select a seat...</li>
                </ul>

                <div class="d-flex justify-content-between align-items-end mb-4">
                    <span class="text-secondary">Total Price</span>
                    <span id="total-price" class="price-tag">$0.00</span>
                </div>

                <form action="{{ route('booking.store', $showtime->id) }}" method="POST" id="booking-form">
                    @csrf
                    <input type="hidden" name="selected_seats" id="hidden-seats-input">
                    
                    <button type="submit" class="btn btn-danger w-100 py-3 fw-bold rounded-pill" id="checkout-btn" disabled>
                        Confirm Booking
                    </button>
                </form>

            </div>
        </div>
    </div>
</div>

<script>
    let selectedSeats = [];
    let totalPrice = 0;

    function toggleSeat(element) {
        if (element.classList.contains('taken')) return;

        const seatId = element.getAttribute('data-id');
        const price = parseFloat(element.getAttribute('data-price'));
        const seatName = element.getAttribute('data-name');

        if (element.classList.contains('selected')) {
            // Deselect
            element.classList.remove('selected');
            selectedSeats = selectedSeats.filter(id => id !== seatId);
            totalPrice -= price;
        } else {
            // Select
            element.classList.add('selected');
            selectedSeats.push(seatId);
            totalPrice += price;
        }

        updateUI();
    }

    function updateUI() {
        const list = document.getElementById('selected-seats-list');
        const totalEl = document.getElementById('total-price');
        const input = document.getElementById('hidden-seats-input');
        const btn = document.getElementById('checkout-btn');

        // Update Total
        totalEl.innerText = '$' + totalPrice.toFixed(2);

        // Update List
        list.innerHTML = '';
        if (selectedSeats.length === 0) {
            list.innerHTML = '<li class="text-secondary small fst-italic">Please select a seat...</li>';
            btn.disabled = true;
            btn.classList.add('btn-secondary'); // Gray out
            btn.classList.remove('btn-danger'); // Remove red
        } else {
            selectedSeats.forEach(id => {
                const seatEl = document.querySelector(`.seat[data-id="${id}"]`);
                const name = seatEl.getAttribute('data-name');
                const price = seatEl.getAttribute('data-price');
                
                list.innerHTML += `
                    <li class="d-flex justify-content-between mb-2">
                        <span>Seat <span class="fw-bold text-white">${name}</span></span>
                        <span class="text-secondary">$${price}</span>
                    </li>`;
            });
            btn.disabled = false;
            btn.classList.remove('btn-secondary');
            btn.classList.add('btn-danger');
        }

        // Update Form Input
        input.value = selectedSeats.join(',');
    }
</script>

</body>
</html>