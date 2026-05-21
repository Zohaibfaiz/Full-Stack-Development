<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    public function showtimes()
{
    return $this->hasMany(Showtime::class);

    
}
protected $fillable = [
    'tmdb_id',
    'title',
    'overview',
    'poster_path',
    'release_date',
    'duration_minutes'
];
}
