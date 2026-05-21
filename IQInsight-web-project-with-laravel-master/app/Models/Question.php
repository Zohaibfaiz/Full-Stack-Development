<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_id',
        'type',
        'prompt',
        'options',
        'answer_key',
        'explanation',
        'order_index',
        'weight',
        'time_limit_seconds',
        'media_url',
    ];

    protected $casts = [
        'options' => 'array',
        'answer_key' => 'array',
    ];

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function grade(?array $submission): int
    {
        $correct = collect($this->answer_key ?? [])->sort()->values();
        $submitted = collect($submission ?? [])->sort()->values();

        return $correct->toJson() === $submitted->toJson() ? $this->weight : 0;
    }
}
