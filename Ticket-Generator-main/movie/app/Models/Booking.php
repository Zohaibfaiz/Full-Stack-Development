<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    public function user()
{
    return $this->belongsTo(User::class);
}

public function showtime()
{
    return $this->belongsTo(Showtime::class);
}

public function tickets()
{
    return $this->hasMany(Ticket::class);
}
protected $fillable = [
    'user_id',
    'showtime_id',
    'total_amount',
    'booking_reference',
    'payment_status'
];
}
