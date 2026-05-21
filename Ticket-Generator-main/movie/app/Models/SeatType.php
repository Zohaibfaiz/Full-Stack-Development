<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeatType extends Model
{
    // Optional: If you ever need to find all seats of a certain type
public function seats()
{
    return $this->hasMany(Seat::class);
}
protected $fillable = [
    'name',
    'description'
];
}
