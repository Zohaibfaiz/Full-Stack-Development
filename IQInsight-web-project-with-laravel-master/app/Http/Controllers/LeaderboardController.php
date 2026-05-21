<?php

namespace App\Http\Controllers;

use App\Models\QuizAttempt;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class LeaderboardController extends Controller
{
    public function index(): View
    {
        $leaders = QuizAttempt::select(
            'user_id',
            DB::raw('MAX(percentage) as best_percentage'),
            DB::raw('MAX(score) as best_score')
        )
            ->groupBy('user_id')
            ->with('user')
            ->orderByDesc('best_percentage')
            ->limit(20)
            ->get();

        $recent = QuizAttempt::with(['quiz', 'user'])->latest()->take(8)->get();

        $userRank = null;
        $userBest = null;

        if (auth()->check()) {
            $userBest = QuizAttempt::where('user_id', auth()->id())->max('percentage');

            if ($userBest !== null) {
                $betterCount = QuizAttempt::select(
                    'user_id',
                    DB::raw('MAX(percentage) as best_percentage')
                )
                    ->groupBy('user_id')
                    ->havingRaw('MAX(percentage) > ?', [$userBest])
                    ->count();

                $userRank = $betterCount + 1;
            }
        }

        return view('leaderboard', [
            'leaders' => $leaders,
            'recent' => $recent,
            'userRank' => $userRank,
            'userBest' => $userBest,
        ]);
    }
}
