<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cinema;
use App\Models\Screen;
use App\Models\Seat;
use App\Models\SeatType;
use Illuminate\Http\Request;

class ScreenController extends Controller
{
    // 1. Show the form to add a screen
    public function create(Cinema $cinema)
    {
        return view('admin.screens.create', compact('cinema'));
    }

    // 2. Save screen AND generate seats automatically
    public function store(Request $request, Cinema $cinema)
{
    // ... validation and screen creation ...
    $screen = $cinema->screens()->create([
        'name' => $request->name,
        'capacity' => $request->rows * $request->cols,
    ]);

    // Get IDs
    $standardId = SeatType::where('name', 'Standard')->first()->id;
    $vipId = SeatType::where('name', 'VIP')->first()->id; // <--- Fetch VIP ID

    $rows = range('A', chr(65 + $request->rows - 1));
    $totalRows = count($rows);

    $rowIndex = 0;
    foreach ($rows as $row) {
        $rowIndex++;

        // Logic: If it is one of the last 2 rows, make it VIP
        $currentType = ($rowIndex > $totalRows - 2) ? $vipId : $standardId;

        for ($number = 1; $number <= $request->cols; $number++) {
            Seat::create([
                'screen_id' => $screen->id,
                'seat_type_id' => $currentType, // <--- Use variable type
                'row' => $row,
                'number' => $number,
            ]);
        }
    }

    return redirect()->route('admin.cinemas.index')->with('success', 'Screen created!');
}
}