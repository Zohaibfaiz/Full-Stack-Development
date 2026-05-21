<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizAttempt;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\View\View;

class QuizController extends Controller
{
    public function index(Request $request): View
    {
        $category = $request->query('category');

        $query = Quiz::active()->withCount('questions');
        if ($category) {
            $query->where('category', $category);
        }

        $quizzes = $query->orderByDesc('created_at')->paginate(9);
        $fresh = Quiz::active()->withCount('questions')->inRandomOrder()->take(4)->get();
        $categories = Quiz::select('category')->distinct()->pluck('category');

        return view('quizzes.index', compact('quizzes', 'fresh', 'categories', 'category'));
    }

    public function show(Quiz $quiz): View
    {
        abort_unless($quiz->is_active, 404);

        $quiz->load(['questions' => fn ($query) => $query->inRandomOrder()]);
        $alternatives = Quiz::active()
            ->where('id', '!=', $quiz->id)
            ->inRandomOrder()
            ->take(3)
            ->get();

        return view('quizzes.show', [
            'quiz' => $quiz,
            'alternatives' => $alternatives,
        ]);
    }

    public function attempt(Request $request, Quiz $quiz): RedirectResponse
    {
        abort_unless($quiz->is_active, 404);

        $quiz->load('questions');

        $answers = $request->input('answers', []);
        $score = 0;
        $maxScore = 0;
        $details = [];

        foreach ($quiz->questions as $question) {
            $submitted = Arr::wrap($answers[$question->id] ?? []);
            $earned = $question->grade($submitted);

            $score += $earned;
            $maxScore += $question->weight;

            $details[] = [
                'question_id' => $question->id,
                'submitted' => $submitted,
                'correct' => $question->answer_key,
                'earned' => $earned,
                'weight' => $question->weight,
            ];
        }

        $percentage = $maxScore > 0 ? round(($score / $maxScore) * 100, 2) : 0;

        $attempt = QuizAttempt::create([
            'quiz_id' => $quiz->id,
            'user_id' => $request->user()->id,
            'score' => $score,
            'max_score' => $maxScore,
            'percentage' => $percentage,
            'time_spent_seconds' => (int) $request->input('time_spent_seconds', 0),
            'finished_at' => now(),
            'answers' => $details,
            'iq_level' => $this->deriveIqLevel($percentage),
        ]);

        $boostedIq = max($request->user()->iq_score ?? 0, $attempt->iqEstimate());
        $request->user()->update(['iq_score' => $boostedIq]);

        return redirect()
            ->route('quizzes.show', $quiz)
            ->with('result', [
                'score' => $score,
                'max' => $maxScore,
                'percentage' => $percentage,
                'iq' => $boostedIq,
                'label' => $attempt->iq_level,
            ]);
    }

    private function deriveIqLevel(float $percentage): string
    {
        return match (true) {
            $percentage >= 90 => 'Genius',
            $percentage >= 75 => 'Advanced',
            $percentage >= 60 => 'Proficient',
            $percentage >= 40 => 'Developing',
            default => 'Explorer',
        };
    }
}
