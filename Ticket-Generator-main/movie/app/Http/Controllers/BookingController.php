<?php

namespace App\Http\Controllers;
use App\Models\Booking;
use App\Models\Showtime;
use App\Models\Seat;
use App\Models\Ticket; // Assuming you have this model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class BookingController extends Controller
{
    public function downloadPDF(Booking $booking)
    {
    // Security check
    if ($booking->user_id !== auth()->id()) { abort(403); }

    // Load the view and pass the data
    $pdf = Pdf::loadView('pdf.ticket', compact('booking'));

    // REQUIRED: Enable 'Remote Enabled' so DomPDF can fetch the QR image from the web
    $pdf->setOption('isRemoteEnabled', true);

    // Download the file
    return $pdf->download('MovieTicket-'.$booking->booking_reference.'.pdf');
    }

    public function index(Showtime $showtime)
    {
        // 1. Get the screen layout for this show
        $screen = $showtime->screen;
        
        // 2. Get all seats for this screen
        // We load the 'type' relationship to show the price name (VIP/Standard)
        $seats = Seat::where('screen_id', $screen->id)
            ->with('type')
            ->get();

        // 3. Get currently booked seat IDs for THIS specific showtime
        // We look at the 'tickets' table which links to 'bookings' for this showtime
        $bookedSeatIds = Ticket::whereHas('booking', function($query) use ($showtime) {
            $query->where('showtime_id', $showtime->id)
                  ->whereIn('payment_status', ['confirmed', 'pending']); // Include pending so double booking doesn't happen
        })->pluck('seat_id')->toArray();

        // 4. Map prices for easy JS access
        // [ 'Standard' => 10.00, 'VIP' => 15.00 ]
        $prices = $showtime->prices->pluck('price', 'seat_type_id');

        return view('booking.index', compact('showtime', 'screen', 'seats', 'bookedSeatIds', 'prices'));
    }

    public function destroy($id)
{
    $booking = Booking::findOrFail($id);
    
    // Optional: Check if user owns the booking
    if ($booking->user_id !== auth()->id()) {
        abort(403);
    }

    // Logic: Delete the booking (and its associated tickets)
    $booking->tickets()->delete(); // Assuming you have a relationship set up
    $booking->delete();

    return redirect()->back()->with('success', 'Booking cancelled successfully.');
}

   public function store(Request $request, Showtime $showtime)
{
    $request->validate([
        'selected_seats' => 'required|string', // "12,14,15"
    ]);

    $seatIds = explode(',', $request->input('selected_seats'));

    try {
        DB::beginTransaction();

        // 1. Double-Check: Are these seats STILL available?
        // (Someone might have booked them while you were deciding)
        $alreadyBooked = Ticket::whereIn('seat_id', $seatIds)
            ->whereHas('booking', function($q) use ($showtime) {
                $q->where('showtime_id', $showtime->id)
                  ->where('payment_status', 'confirmed');
            })->exists();

        if ($alreadyBooked) {
            return back()->with('error', 'One or more of your selected seats were just taken! Please try again.');
        }

        // 2. Calculate Total Price
        // We fetch the prices again from DB to prevent "Inspect Element" hacking
        $totalPrice = 0;
        $seats = Seat::whereIn('id', $seatIds)->get();
        
        // Get price map for this showtime: [ seat_type_id => price ]
        $priceMap = $showtime->prices->pluck('price', 'seat_type_id');

        foreach ($seats as $seat) {
            $totalPrice += $priceMap[$seat->seat_type_id];
        }

        // 3. Create the Booking Record
        $booking = Booking::create([
            'user_id' => Auth::id(),
            'showtime_id' => $showtime->id,
            'total_amount' => $totalPrice,
            'payment_status' => 'confirmed', // "Dummy Payment" instant success
            'booking_reference' => strtoupper(uniqid('BK-')),
        ]);

        // 4. Create Individual Tickets
        foreach ($seats as $seat) {
            Ticket::create([
                'booking_id' => $booking->id,
                'seat_id' => $seat->id,
                'price_paid' => $priceMap[$seat->seat_type_id],
            ]);
        }

        DB::commit();

        return redirect()->route('booking.success', $booking->id);

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Something went wrong. Please try again.');
    }
}
}