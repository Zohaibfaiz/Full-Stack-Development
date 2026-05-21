<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TMDBService
{
    protected $baseUrl = 'https://api.themoviedb.org/3';
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = env('TMDB_API_KEY');
    }

    public function searchMovie($query)
    {
        $response = Http::get("{$this->baseUrl}/search/movie", [
            'api_key' => $this->apiKey,
            'query' => $query,
        ]);

        return $response->json()['results'];
    }

    public function getMovieDetails($tmdbId)
    {
        $response = Http::get("{$this->baseUrl}/movie/{$tmdbId}", [
            'api_key' => $this->apiKey,
        ]);

        return $response->json();
    }
}