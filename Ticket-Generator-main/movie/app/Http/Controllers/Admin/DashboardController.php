<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Movie;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Total Revenue (Sum of all confirmed bookings)
        $totalRevenue = Booking::where('payment_status', 'confirmed')->sum('total_amount');

        // 2. Total Tickets Sold
        $totalTickets = Ticket::count();

        // 3. Best Selling Movie (The trickiest query!)
        // We join Tickets -> Bookings -> Showtimes -> Movies to count tickets per movie
        $bestMovie = Movie::select('movies.title')
            ->join('showtimes', 'movies.id', '=', 'showtimes.movie_id')
            ->join('bookings', 'showtimes.id', '=', 'bookings.showtime_id')
            ->join('tickets', 'bookings.id', '=', 'tickets.booking_id')
            ->selectRaw('count(tickets.id) as tickets_sold')
            ->groupBy('movies.id', 'movies.title')
            ->orderByDesc('tickets_sold')
            ->first();

        // 4. Latest 5 Bookings (For a quick list)
        $latestBookings = Booking::with('user', 'showtime.movie')
            ->where('payment_status', 'confirmed')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('totalRevenue', 'totalTickets', 'bestMovie', 'latestBookings'));
    }
}