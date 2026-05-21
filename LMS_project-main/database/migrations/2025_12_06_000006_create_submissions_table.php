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
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            // Submission may relate to an assignment or a quiz
            $table->foreignId('assignment_id')->nullable()->constrained('assignments')->onDelete('cascade');
            $table->foreignId('quiz_id')->nullable()->constrained('quizzes')->onDelete('cascade');
            $table->string('file_path');
            $table->integer('marks')->nullable();
            $table->text('feedback')->nullable();
            $table->timestamp('submitted_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submissions');
    }
};