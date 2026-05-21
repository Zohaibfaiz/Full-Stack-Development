<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'registration_number',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            // password is hashed when stored
            'password' => 'hashed',
        ];
    }

    /**
     * Courses taught by the user (when the user is a teacher).
     */
    public function taughtCourses()
    {
        return $this->hasMany(Course::class, 'teacher_id');
    }

    /**
     * Courses the student is enrolled in.
     */
    public function courses()
    {
        return $this->belongsToMany(Course::class)->withTimestamps()->withPivot('status');
    }

    /**
     * Learning resources uploaded by the user.
     */
    public function uploadedResources()
    {
        return $this->hasMany(LearningResource::class, 'uploaded_by');
    }

    /**
     * Submissions created by the user.
     */
    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    /**
     * Attendance records for the user.
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    /**
     * Marks associated with the user.
     */
    public function marks()
    {
        return $this->hasMany(Mark::class);
    }

    /**
     * Course requests made by the user.
     */
    public function courseRequests()
    {
        return $this->hasMany(CourseRequest::class);
    }

    /**
     * Course proposals submitted by the teacher for admin approval.
     */
    public function courseProposals()
    {
        return $this->hasMany(CourseProposal::class, 'teacher_id');
    }
}
