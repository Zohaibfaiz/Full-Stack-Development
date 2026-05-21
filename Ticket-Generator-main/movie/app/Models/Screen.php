<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Screen extends Model
{
    public function cinema()
{
    return $this->belongsTo(Cinema::class);
}

public function seats()
{
    return $this->hasMany(Seat::class);
}

public function showtimes()
{
    return $this->hasMany(Showtime::class);
}

protected $fillable = [
    'cinema_id',
    'name',
    'capacity'
];
}
