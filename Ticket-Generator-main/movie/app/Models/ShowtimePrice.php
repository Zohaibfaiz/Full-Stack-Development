<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShowtimePrice extends Model
{
    public function showtime()
{
    return $this->belongsTo(Showtime::class);
}

public function seatType()
{
    return $this->belongsTo(SeatType::class);
}
protected $fillable = [
    'showtime_id',
    'seat_type_id',
    'price'
];
}
