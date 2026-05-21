<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            // Course name and optional description
            $table->string('name');
            $table->text('description')->nullable();
            // Teacher responsible for the course (references users table)
            $table->foreignId('teacher_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

        // Pivot table to associate students with courses
        Schema::create('course_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            // Status of the enrollment (pending, approved, rejected)
            $table->string('status')->default('approved');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_user');
        Schema::dropIfExists('courses');
    }
};