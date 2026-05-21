<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'category',
        'difficulty',
        'description',
        'time_limit_seconds',
        'question_count',
        'is_active',
        'metadata',
        'created_by',
    ];

    protected $casts = [
        'metadata' => 'array',
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function (Quiz $quiz) {
            if (empty($quiz->slug)) {
                $quiz->slug = Str::slug($quiz->title) . '-' . Str::random(4);
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class)->orderBy('order_index');
    }

    public function attempts(): HasMany
    {
        return $this->hasMany(QuizAttempt::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}
