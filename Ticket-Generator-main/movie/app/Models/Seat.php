<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    public function screen()
{
    return $this->belongsTo(Screen::class);
}

public function type()
{
    return $this->belongsTo(SeatType::class, 'seat_type_id');
}
protected $fillable = [
    'screen_id',
    'seat_type_id',
    'row',
    'number'
];
}
