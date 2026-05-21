<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cinema;
use App\Models\Movie;
use App\Models\SeatType;
use App\Models\Showtime;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ShowtimeController extends Controller
{
    public function create(Cinema $cinema)
    {
        // Fetch data needed for the dropdowns
        $movies = Movie::all();
        $screens = $cinema->screens; 
        $seatTypes = SeatType::all();

        return view('admin.showtimes.create', compact('cinema', 'movies', 'screens', 'seatTypes'));
    }

    public function store(Request $request, Cinema $cinema)
    {
        $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'screen_id' => 'required|exists:screens,id',
            'start_time' => 'required|date',
            'prices' => 'required|array', // Expecting an array like [1 => 10.00, 2 => 15.00]
        ]);

        // Optional: Fetch actual movie duration to calculate end_time accurately
        $movie = Movie::find($request->movie_id);
        $duration = $movie->duration_minutes ?? 120;

        // 1. Create the Showtime
        $showtime = Showtime::create([
            'movie_id' => $request->movie_id,
            'screen_id' => $request->screen_id,
            'start_time' => $request->start_time,
            'end_time' => Carbon::parse($request->start_time)->addMinutes($duration),
        ]);

        // 2. Save the Prices into the pivot table
        foreach ($request->prices as $typeId => $price) {
            $showtime->prices()->create([
                'seat_type_id' => $typeId,
                'price' => $price,
            ]);
        }

        return redirect()->route('admin.cinemas.index')->with('success', 'Showtime scheduled successfully!');
    }
}