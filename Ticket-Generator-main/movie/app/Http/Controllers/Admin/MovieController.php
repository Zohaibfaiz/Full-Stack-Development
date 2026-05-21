<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Services\TMDBService;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    protected $tmdb;

    public function __construct(TMDBService $tmdb)
    {
        $this->tmdb = $tmdb;
    }

    // 1. Show the list of movies in our DB
    public function index()
    {
        $movies = Movie::latest()->paginate(10);
        return view('admin.movies.index', compact('movies'));
    }

    // 2. Show the search form and results
    public function search(Request $request)
    {
        $results = [];
        if ($request->has('query')) {
            $results = $this->tmdb->searchMovie($request->input('query'));
        }
        return view('admin.movies.search', compact('results'));
    }

    // 3. Save a movie from TMDB to our Database
    public function import(Request $request)
    {
        $tmdbId = $request->input('tmdb_id');
        
        // Check if we already have it
        if (Movie::where('tmdb_id', $tmdbId)->exists()) {
            return back()->with('error', 'Movie already exists!');
        }

        // Fetch full details
        $data = $this->tmdb->getMovieDetails($tmdbId);

        Movie::create([
            'tmdb_id' => $data['id'],
            'title' => $data['title'],
            'overview' => $data['overview'],
            'poster_path' => "https://image.tmdb.org/t/p/w500" . $data['poster_path'],
            'release_date' => $data['release_date'],
            'duration_minutes' => $data['runtime'] ?? 120, // Default if null
        ]);

        return redirect()->route('admin.movies.index')->with('success', 'Movie imported successfully!');
    }
}