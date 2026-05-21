<?php
use App\Http\Controllers\Admin\MovieController;
use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookingController;
use App\Models\Booking;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/movie/{id}', [HomeController::class, 'show'])->name('movies.show');

// Admin Dashboard Routes
Route::middleware(['auth', IsAdmin::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        Route::get('/movies/search', [MovieController::class, 'search'])->name('movies.search');
        Route::post('/movies/import', [MovieController::class, 'import'])->name('movies.import');
        Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');
        Route::resource('cinemas', \App\Http\Controllers\Admin\CinemaController::class);
        // Add this line for Screens (We only need create and store for now)    
        Route::get('cinemas/{cinema}/screens/create', [\App\Http\Controllers\Admin\ScreenController::class, 'create'])->name('screens.create');
        Route::post('cinemas/{cinema}/screens', [\App\Http\Controllers\Admin\ScreenController::class, 'store'])->name('screens.store');
        Route::get('cinemas/{cinema}/showtimes/create', [\App\Http\Controllers\Admin\ShowtimeController::class, 'create'])->name('showtimes.create');
        Route::post('cinemas/{cinema}/showtimes', [\App\Http\Controllers\Admin\ShowtimeController::class, 'store'])->name('showtimes.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/booking/{showtime}', [BookingController::class, 'index'])->name('booking.index');
    Route::post('/booking/{showtime}/reserve', [BookingController::class, 'store'])->name('booking.store');
    Route::delete('/booking/{id}/cancel', [BookingController::class, 'destroy'])->name('booking.cancel');
    Route::get('/booking/success/{booking}', function (\App\Models\Booking $booking) {
    // Security: Ensure user can only see their own booking
    if ($booking->user_id !== auth()->id()) { abort(403); } return view('booking.success', compact('booking')); })->name('booking.success');
    Route::get('/booking/{booking}/download', [\App\Http\Controllers\BookingController::class, 'downloadPDF'])->name('booking.download'); 
});

Route::get('/dashboard', function () {
    // Fetch user's bookings, ordered by newest first
    $bookings = Booking::where('user_id', auth()->id())
        ->with(['showtime.movie', 'showtime.screen.cinema', 'tickets'])
        ->latest()
        ->get();

    return view('dashboard', compact('bookings'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Breeze loads the auth routes (Login/Register) automatically here:
require __DIR__.'/auth.php';