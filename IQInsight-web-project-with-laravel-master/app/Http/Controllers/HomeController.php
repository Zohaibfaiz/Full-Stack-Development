<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizAttempt;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $featured = Quiz::active()->withCount('questions')->latest()->take(3)->get();
        $fresh = Quiz::active()->withCount('questions')->inRandomOrder()->take(6)->get();
        $categories = Quiz::select('category')->distinct()->pluck('category');
        $topAttempts = QuizAttempt::with(['user', 'quiz'])
            ->orderByDesc('percentage')
            ->take(5)
            ->get();

        return view('home', [
            'featured' => $featured,
            'fresh' => $fresh,
            'categories' => $categories,
            'topAttempts' => $topAttempts,
        ]);
    }
}
