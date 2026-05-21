<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'assignment_id',
        'quiz_id',
        'file_path',
        'marks',
        'feedback',
        'submitted_at',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}