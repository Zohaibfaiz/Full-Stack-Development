<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\QuizAttempt;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@iq.test'],
            [
                'name' => 'Admin IQ',
                'password' => Hash::make('password'),
                'is_admin' => true,
                'iq_score' => 145,
                'email_verified_at' => now(),
            ]
        );

        $player = User::updateOrCreate(
            ['email' => 'player@iq.test'],
            [
                'name' => 'Sample Player',
                'password' => Hash::make('password'),
                'iq_score' => 120,
                'email_verified_at' => now(),
            ]
        );

        $quizzes = [
            [
                'title' => 'Logic Sparks',
                'category' => 'logical',
                'difficulty' => 'medium',
                'description' => 'Deductive reasoning, conditionals, and pattern logic to stretch your analytic muscles.',
                'time_limit_seconds' => 240,
                'questions' => [
                    [
                        'prompt' => 'If all bloops are razzies and all razzies are lazzies, are all bloops lazzies?',
                        'options' => ['A' => 'Yes', 'B' => 'No', 'C' => 'Only some', 'D' => 'Cannot be determined'],
                        'answer_key' => ['A'],
                        'weight' => 2,
                    ],
                    [
                        'prompt' => 'Which statement must be true if the first two are true? "All coders are thinkers." "Some thinkers are designers."',
                        'options' => ['A' => 'All designers are coders', 'B' => 'Some coders may be designers', 'C' => 'No coder is a designer', 'D' => 'All thinkers are coders'],
                        'answer_key' => ['B'],
                        'weight' => 2,
                    ],
                    [
                        'prompt' => 'Complete the analogy: strategy is to tactics as architecture is to ______.',
                        'options' => ['A' => 'blueprint', 'B' => 'brick', 'C' => 'city', 'D' => 'foundation'],
                        'answer_key' => ['A'],
                        'weight' => 1,
                    ],
                ],
            ],
            [
                'title' => 'Graphical IQ Grid',
                'category' => 'graphical',
                'difficulty' => 'advanced',
                'description' => 'Visual sequencing and spatial flips to test pattern recognition speed.',
                'time_limit_seconds' => 180,
                'questions' => [
                    [
                        'prompt' => 'A square is folded along a diagonal. Which shape do you get when unfolded after cutting a small triangle on the fold?',
                        'options' => ['A' => 'Two mirrored triangles', 'B' => 'A diamond shape', 'C' => 'Two separate squares', 'D' => 'A pentagon'],
                        'answer_key' => ['A'],
                        'weight' => 2,
                    ],
                    [
                        'prompt' => 'Which transformation keeps an equilateral triangle identical?',
                        'options' => ['A' => 'Rotation 90 deg', 'B' => 'Rotation 120 deg', 'C' => 'Reflection across any median', 'D' => 'Both B and C'],
                        'answer_key' => ['D'],
                        'weight' => 2,
                    ],
                ],
            ],
            [
                'title' => 'Math & Sequences Sprint',
                'category' => 'math',
                'difficulty' => 'medium',
                'description' => 'Number patterns, ratios, and quick arithmetic brain warmups.',
                'time_limit_seconds' => 210,
                'questions' => [
                    [
                        'prompt' => 'What comes next? 2, 6, 12, 20, 30, ___',
                        'options' => ['A' => '38', 'B' => '40', 'C' => '42', 'D' => '44'],
                        'answer_key' => ['B'],
                        'weight' => 2,
                    ],
                    [
                        'prompt' => 'If 4y + 2 = 3y + 12, what is y?',
                        'options' => ['A' => '8', 'B' => '10', 'C' => '12', 'D' => '14'],
                        'answer_key' => ['A'],
                        'weight' => 1,
                    ],
                    [
                        'prompt' => 'Pick the ratio that equals 3/5.',
                        'options' => ['A' => '9/15', 'B' => '12/10', 'C' => '18/45', 'D' => '21/25'],
                        'answer_key' => ['A'],
                        'weight' => 1,
                    ],
                ],
            ],
            [
                'title' => 'Sequence Decoder',
                'category' => 'sequences',
                'difficulty' => 'advanced',
                'description' => 'Test your ability to decode directional and symbolic sequences quickly.',
                'time_limit_seconds' => 200,
                'questions' => [
                    [
                        'prompt' => 'If F1 = 3, F2 = 5, and F3 = F1 + F2, what is F3?',
                        'options' => ['A' => '7', 'B' => '8', 'C' => '9', 'D' => '10'],
                        'answer_key' => ['C'],
                        'weight' => 2,
                    ],
                    [
                        'prompt' => 'Fill the blank: Monday, Thursday, Sunday, ____, Sunday (pattern repeats every 3).',
                        'options' => ['A' => 'Tuesday', 'B' => 'Wednesday', 'C' => 'Thursday', 'D' => 'Friday'],
                        'answer_key' => ['B'],
                        'weight' => 1,
                    ],
                ],
            ],
        ];

        foreach ($quizzes as $data) {
            $quiz = Quiz::updateOrCreate(
                ['title' => $data['title']],
                [
                    'category' => $data['category'],
                    'difficulty' => $data['difficulty'],
                    'description' => $data['description'],
                    'time_limit_seconds' => $data['time_limit_seconds'],
                    'question_count' => count($data['questions']),
                    'created_by' => $admin->id,
                    'metadata' => ['tags' => ['logic', 'spatial', 'math', 'sequence']],
                ]
            );

            $quiz->questions()->delete();

            foreach ($data['questions'] as $order => $question) {
                Question::create([
                    'quiz_id' => $quiz->id,
                    'prompt' => $question['prompt'],
                    'type' => $question['type'] ?? 'single-choice',
                    'options' => $question['options'] ?? null,
                    'answer_key' => $question['answer_key'] ?? [],
                    'weight' => $question['weight'] ?? 1,
                    'order_index' => $order,
                ]);
            }
        }

        // Seed a starter attempt to show on the leaderboard
        $firstQuiz = Quiz::first();
        if ($firstQuiz) {
            QuizAttempt::updateOrCreate(
                [
                    'quiz_id' => $firstQuiz->id,
                    'user_id' => $player->id,
                ],
                [
                    'score' => 4,
                    'max_score' => 6,
                    'percentage' => 66.7,
                    'time_spent_seconds' => 95,
                    'finished_at' => now()->subMinutes(15),
                    'answers' => [],
                    'iq_level' => 'Proficient',
                ]
            );
        }
    }
}
