<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_id',
        'user_id',
        'score',
        'max_score',
        'percentage',
        'time_spent_seconds',
        'finished_at',
        'answers',
        'iq_level',
    ];

    protected $casts = [
        'answers' => 'array',
        'finished_at' => 'datetime',
        'percentage' => 'float',
        'score' => 'integer',
        'max_score' => 'integer',
        'time_spent_seconds' => 'integer',
    ];

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function iqEstimate(): int
    {
        return (int) round(80 + ($this->percentage / 100) * 70);
    }
}
