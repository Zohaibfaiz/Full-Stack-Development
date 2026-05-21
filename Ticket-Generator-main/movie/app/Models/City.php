<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public function cinemas()
{
    return $this->hasMany(Cinema::class);
}
protected $fillable = ['name'];
}
