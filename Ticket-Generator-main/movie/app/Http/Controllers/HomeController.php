<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Showtime;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HomeController extends Controller
{
    // 1. Homepage: Show movies currently playing
    public function index()
    {
        // Get movies that have at least one showtime in the future
        $movies = Movie::whereHas('showtimes', function($query) {
            $query->where('start_time', '>', now());
        })->get();

        return view('welcome', compact('movies'));
    }

    // 2. Movie Details: Show the poster + list of cinemas playing it
    public function show($id)
    {
        $movie = Movie::findOrFail($id);

        // Fetch showtimes for this movie, grouped by Cinema
        // We only want future showtimes, ordered by time
        $showtimes = Showtime::with(['screen.cinema', 'prices'])
            ->where('movie_id', $id)
            ->where('start_time', '>', now())
            ->orderBy('start_time')
            ->get()
            ->groupBy(function($data) {
                return $data->screen->cinema->name; // Group by Cinema Name
            });

        return view('movies.show', compact('movie', 'showtimes'));
    }
}