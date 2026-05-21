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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->constrained()->cascadeOnDelete();
            $table->string('type')->default('single-choice');
            $table->text('prompt');
            $table->json('options')->nullable();
            $table->json('answer_key')->nullable();
            $table->text('explanation')->nullable();
            $table->unsignedInteger('order_index')->default(0);
            $table->unsignedInteger('weight')->default(1);
            $table->unsignedInteger('time_limit_seconds')->nullable();
            $table->string('media_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
