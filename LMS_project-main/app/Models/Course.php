<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'teacher_id',
    ];

    /**
     * Get the teacher who owns the course.
     */
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    /**
     * The students that belong to the course.
     */
    public function students()
    {
        return $this->belongsToMany(User::class)->withTimestamps()->withPivot('status');
    }

    /**
     * Get the assignments for the course.
     */
    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }

    /**
     * Get the quizzes for the course.
     */
    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    /**
     * Get the resources for the course.
     */
    public function resources()
    {
        // Use LearningResource to avoid collision with PHP's Resource type
        return $this->hasMany(LearningResource::class);
    }

    /**
     * Get the attendances for the course.
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    /**
     * Get the marks for the course.
     */
    public function marks()
    {
        return $this->hasMany(Mark::class);
    }

    /**
     * Get the course requests for this course.
     */
    public function requests()
    {
        return $this->hasMany(CourseRequest::class);
    }
}