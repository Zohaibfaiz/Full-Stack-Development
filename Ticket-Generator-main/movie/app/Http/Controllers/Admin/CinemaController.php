<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cinema;
use App\Models\City;
use Illuminate\Http\Request;

class CinemaController extends Controller
{
    // 1. List all cinemas
    public function index()
    {
        // We load the 'city' relationship to show the city name efficiently
        $cinemas = Cinema::with('city')->latest()->paginate(10);
        return view('admin.cinemas.index', compact('cinemas'));
    }

    // 2. Show the "Create New Cinema" form
    public function create()
    {
        $cities = City::all(); // We need this for the dropdown
        return view('admin.cinemas.create', compact('cities'));
    }

    // 3. Store the new cinema in the database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'city_id' => 'required|exists:cities,id',
            'location' => 'required|string',
        ]);

        Cinema::create($request->all());

        return redirect()->route('admin.cinemas.index')
                         ->with('success', 'Cinema created successfully!');
    }
}