@php use Illuminate\Support\Str; @endphp
@extends('layouts.app')

@section('content')
    <div class="hero-surface rounded-4 p-4 p-lg-5 mb-4 fade-rise">
        <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
            <div>
                <p class="text-secondary mb-1 text-uppercase small">Adaptive IQ games</p>
                <h2 class="fw-bold mb-1">Pick your next challenge</h2>
                <p class="text-secondary mb-0">Logical | Graphical | Math | Sequences | Memory | Spatial reasoning</p>
            </div>
            <a href="{{ route('leaderboard') }}" class="btn btn-outline-light">Live leaderboard</a>
        </div>

        <div class="d-flex flex-wrap gap-2 align-items-center mt-3">
            <span class="text-secondary me-2">Filter by category:</span>
            <a href="{{ route('quizzes.index') }}" class="btn btn-sm {{ !$category ? 'btn-accent' : 'btn-outline-light' }}">All</a>
            @foreach ($categories as $cat)
                <a href="{{ route('quizzes.index', ['category' => $cat]) }}"
                   class="btn btn-sm {{ $category === $cat ? 'btn-accent' : 'btn-outline-light' }}">
                    {{ ucfirst($cat) }}
                </a>
            @endforeach
        </div>
    </div>

    <div class="fade-rise mb-4">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <div>
                <p class="text-secondary mb-1 text-uppercase small">Freshly rotated</p>
                <h5 class="mb-0 fw-semibold">Quizzes re-rolled just now</h5>
            </div>
            <span class="badge badge-soft">{{ $fresh->count() }} live</span>
        </div>
        <div class="row g-3">
            @forelse ($fresh as $quiz)
                <div class="col-md-3">
                    <div class="card h-100 p-3 border-0">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="badge badge-soft text-uppercase">{{ $quiz->category }}</span>
                            <span class="text-secondary small d-flex align-items-center gap-1">
                                <i class="bi bi-activity"></i> {{ ucfirst($quiz->difficulty) }}
                            </span>
                        </div>
                        <h6 class="fw-semibold">{{ $quiz->title }}</h6>
                        <p class="text-secondary small mb-3">{{ Str::limit($quiz->description, 70) }}</p>
                        <div class="d-flex justify-content-between text-secondary small mb-3">
                            <span><i class="bi bi-question-circle"></i> {{ $quiz->question_count ?: ($quiz->questions_count ?? $quiz->questions()->count()) }} Qs</span>
                            <span><i class="bi bi-clock"></i> {{ $quiz->time_limit_seconds ?? 0 }}s</span>
                        </div>
                        <div class="divider-dash mb-3"></div>
                        <a href="{{ route('quizzes.show', $quiz) }}" class="btn btn-sm btn-outline-light w-100">Play</a>
                    </div>
                </div>
            @empty
                <p class="text-secondary mb-0">No quizzes yet.</p>
            @endforelse
        </div>
    </div>

    <div class="fade-rise">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <p class="text-secondary mb-1 text-uppercase small">All quizzes</p>
                <h4 class="fw-semibold mb-0">Browse the full arena</h4>
            </div>
            <span class="text-secondary small">Login required to submit scores</span>
        </div>
        <div class="row g-3">
            @foreach ($quizzes as $quiz)
                <div class="col-md-4">
                    <div class="card h-100 p-3 border-0">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="badge text-bg-dark text-uppercase">{{ $quiz->category }}</span>
                            <span class="text-secondary small"><i class="bi bi-activity me-1"></i>{{ ucfirst($quiz->difficulty) }}</span>
                        </div>
                        <h5 class="fw-semibold">{{ $quiz->title }}</h5>
                        <p class="text-secondary small">{{ Str::limit($quiz->description, 120) }}</p>
                        <div class="d-flex justify-content-between text-secondary small mb-3">
                            <span><i class="bi bi-question-circle"></i> {{ $quiz->question_count ?: ($quiz->questions_count ?? $quiz->questions()->count()) }} Qs</span>
                            <span><i class="bi bi-clock"></i> {{ $quiz->time_limit_seconds ?? 0 }}s</span>
                        </div>
                        <div class="divider-dash mb-3"></div>
                        <a href="{{ route('quizzes.show', $quiz) }}" class="btn btn-outline-light w-100">Open & play</a>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-3">
            {{ $quizzes->links() }}
        </div>
    </div>
@endsection
