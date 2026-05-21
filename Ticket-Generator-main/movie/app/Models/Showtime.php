<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Showtime extends Model
{
    public function movie()
{
    return $this->belongsTo(Movie::class);
}

public function screen()
{
    return $this->belongsTo(Screen::class);
}

public function bookings()
{
    return $this->hasMany(Booking::class);
}

// Helper to get price for a specific seat type
public function prices()
{
    return $this->hasMany(ShowtimePrice::class);
}
protected $fillable = [
    'movie_id',
    'screen_id',
    'start_time',
    'end_time'
];
}
