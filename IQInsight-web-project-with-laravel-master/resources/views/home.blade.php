@php use Illuminate\Support\Str; @endphp
@extends('layouts.app')

@section('content')
    <div class="hero-surface rounded-4 p-4 p-lg-5 mb-5 position-relative overflow-hidden fade-rise">
        <div class="position-absolute top-0 end-0 p-3 d-none d-md-block">
            <div class="pill badge-glow">
                <i class="bi bi-activity"></i>
                Live IQ pulse
            </div>
        </div>
        <div class="row g-4 align-items-center">
            <div class="col-lg-6">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-2 rounded-pill badge-soft mb-3">
                    <i class="bi bi-stars text-info"></i>
                    Season 02 — Dynamic IQ arenas
                </div>
                <h1 class="display-5 fw-bold mb-3">
                    Challenge your mind with <span class="gradient-text">IQInsight</span>
                </h1>
                <p class="text-secondary lead mb-4">
                    Rapid-fire logic, visual sequences, math and memory drills. Adaptive games, instant scoring,
                    and a live leaderboard that rewards your next best run.
                </p>
                <div class="d-flex gap-3 flex-wrap mb-3">
                    <a href="{{ route('quizzes.index') }}" class="btn btn-accent btn-lg px-4">
                        Start a new game
                    </a>
                    <a href="{{ route('leaderboard') }}" class="btn btn-outline-light btn-lg px-4">
                        View leaderboard
                    </a>
                </div>
                <div class="d-flex flex-wrap gap-2">
                    <div class="pill"><i class="bi bi-lightning-charge-fill text-info"></i><span>Adaptive pace</span></div>
                    <div class="pill"><i class="bi bi-magic text-warning"></i><span>Visual + logic blends</span></div>
                    <div class="pill"><i class="bi bi-shield-check text-success"></i><span>Fair scoring</span></div>
                </div>
                @guest
                    <div class="alert alert-info glass border-0 mt-4 mb-0">
                        <i class="bi bi-lock-fill me-2"></i> Login or sign up before playing to save your IQ rank.
                    </div>
                @endguest
            </div>
            <div class="col-lg-6">
                <div class="row g-3">
                    @foreach ($categories as $category)
                        <div class="col-6">
                            <div class="card rounded-4 border-0 p-3 h-100">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="badge badge-glow text-uppercase">{{ $category }}</span>
                                    <i class="bi bi-arrow-up-right text-secondary"></i>
                                </div>
                                <h6 class="fw-semibold mb-1 text-white">{{ ucfirst($category) }} arena</h6>
                                <p class="text-secondary small mb-0">Rotating puzzles, tighter time caps.</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="row g-3 mt-2">
                    <div class="col-4">
                        <div class="stat-chip text-center">
                            <div class="text-secondary small">Categories</div>
                            <div class="h5 fw-bold mb-0">{{ $categories->count() }}</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="stat-chip text-center">
                            <div class="text-secondary small">Fresh picks</div>
                            <div class="h5 fw-bold mb-0">{{ $fresh->count() }}</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="stat-chip text-center">
                            <div class="text-secondary small">Featured</div>
                            <div class="h5 fw-bold mb-0">{{ $featured->count() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-5 fade-rise">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <div>
                <p class="text-secondary mb-1 text-uppercase small">Fresh drops</p>
                <h4 class="fw-semibold mb-0">New puzzles tuned for speed</h4>
            </div>
            <a href="{{ route('quizzes.index') }}" class="text-secondary small">See all quizzes</a>
        </div>
        <div class="row g-3">
            @foreach ($fresh as $quiz)
                <div class="col-md-6 col-lg-4">
                    <div class="card rounded-4 h-100 p-3 border-0">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="badge badge-soft text-uppercase">{{ $quiz->category }}</span>
                            <span class="text-secondary small d-flex align-items-center gap-1">
                                <i class="bi bi-activity"></i> {{ ucfirst($quiz->difficulty) }}
                            </span>
                        </div>
                        <h5 class="fw-semibold mb-1">{{ $quiz->title }}</h5>
                        <p class="text-secondary small mb-3">{{ Str::limit($quiz->description, 90) }}</p>
                        <div class="d-flex align-items-center justify-content-between text-secondary small mb-3">
                            <span><i class="bi bi-question-circle"></i> {{ $quiz->question_count ?: ($quiz->questions_count ?? $quiz->questions()->count()) }} Qs</span>
                            <span><i class="bi bi-clock-history"></i> {{ $quiz->time_limit_seconds ?? 0 }}s</span>
                        </div>
                        <div class="divider-dash mb-3"></div>
                        <a href="{{ route('quizzes.show', $quiz) }}" class="btn btn-outline-light btn-sm w-100">
                            Play this quiz
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="row g-3 align-items-stretch fade-rise mb-5">
        <div class="col-lg-6">
            <div class="card rounded-4 p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="fw-semibold mb-0">Featured arenas</h4>
                    <span class="badge badge-glow text-uppercase">Curated</span>
                </div>
                @forelse ($featured as $quiz)
                    <div class="d-flex align-items-center justify-content-between py-2 border-bottom border-dark">
                        <div>
                            <div class="text-white fw-semibold">{{ $quiz->title }}</div>
                            <div class="text-secondary small text-uppercase">{{ $quiz->category }} | {{ $quiz->difficulty }}</div>
                        </div>
                        <a href="{{ route('quizzes.show', $quiz) }}" class="btn btn-sm btn-accent">Play</a>
                    </div>
                @empty
                    <p class="text-secondary mb-0">No featured quizzes yet.</p>
                @endforelse
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card rounded-4 p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="fw-semibold mb-0">Live leaderboard pulse</h4>
                    <span class="badge text-bg-success">Real-time</span>
                </div>
                <div class="list-group list-group-flush">
                    @forelse ($topAttempts as $attempt)
                        <div class="list-group-item bg-transparent text-white d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fw-semibold">{{ $attempt->user->name ?? 'Anonymous' }}</div>
                                <small class="text-secondary">{{ $attempt->quiz->title ?? 'Quiz' }}</small>
                            </div>
                            <div class="text-end">
                                <div class="fw-bold text-info">{{ $attempt->percentage }}%</div>
                                <small class="text-secondary">Score: {{ $attempt->score }}/{{ $attempt->max_score }}</small>
                            </div>
                        </div>
                    @empty
                        <p class="text-secondary mb-0">Play a quiz to appear here.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="text-center fade-rise">
        <div class="glass rounded-4 p-4 p-lg-5 d-inline-block">
            <div class="d-inline-flex align-items-center gap-2 badge-soft px-3 py-2 mb-3">
                <i class="bi bi-activity text-info"></i>
                Next up
            </div>
            <h4 class="fw-semibold mb-2">Ready for your next IQ check?</h4>
            <p class="text-secondary mb-3">Pick a category, play a fresh quiz, and watch your leaderboard position update instantly.</p>
            <a href="{{ route('quizzes.index') }}" class="btn btn-accent px-4">Find my next game</a>
        </div>
    </div>
@endsection
