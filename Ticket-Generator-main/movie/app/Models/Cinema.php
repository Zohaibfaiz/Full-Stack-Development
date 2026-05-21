<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cinema extends Model
{
    public function city()
{
    return $this->belongsTo(City::class);
}

public function screens()
{
    return $this->hasMany(Screen::class);
}
protected $fillable = [
    'city_id',
    'name',
    'location'
];
}
