<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\User;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function index(): View
    {
        abort_unless(auth()->check() && auth()->user()->is_admin, 403);

        $stats = [
            'users' => User::count(),
            'quizzes' => Quiz::count(),
            'active_quizzes' => Quiz::where('is_active', true)->count(),
            'attempts' => QuizAttempt::count(),
        ];

        $recentAttempts = QuizAttempt::with(['user', 'quiz'])
            ->latest()
            ->take(8)
            ->get();

        $popularQuizzes = Quiz::withCount('attempts')
            ->orderByDesc('attempts_count')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentAttempts', 'popularQuizzes'));
    }
}
