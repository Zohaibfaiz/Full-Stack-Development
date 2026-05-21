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
    Schema::create('tickets', function (Blueprint $table) {
        $table->id();
        $table->foreignId('booking_id')->constrained()->cascadeOnDelete();
        $table->foreignId('seat_id')->constrained()->cascadeOnDelete();
        $table->decimal('price_paid', 8, 2); // Snapshot of price at time of booking
        $table->timestamps();

        // This is the critical constraint: A seat can only be booked ONCE per showtime.
        // We use a unique index on (seat_id + showtime_id) via the booking/ticket relationship.
        $table->unique(['seat_id', 'booking_id']); 
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
