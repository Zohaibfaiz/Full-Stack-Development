@php use Illuminate\Support\Str; @endphp
@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 fade-rise">
        <div>
            <p class="text-secondary mb-1 text-uppercase small">Admin panel</p>
            <h2 class="fw-bold mb-0">IQInsight activity</h2>
        </div>
        <span class="badge text-bg-success">Live</span>
    </div>

    <div class="row g-3 mb-4 fade-rise">
        <div class="col-md-3">
            <div class="card rounded-4 p-3">
                <p class="text-secondary small mb-1">Users</p>
                <h4 class="fw-bold mb-0">{{ $stats['users'] }}</h4>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card rounded-4 p-3">
                <p class="text-secondary small mb-1">Quizzes</p>
                <h4 class="fw-bold mb-0">{{ $stats['quizzes'] }} <span class="text-success small">({{ $stats['active_quizzes'] }} active)</span></h4>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card rounded-4 p-3">
                <p class="text-secondary small mb-1">Attempts</p>
                <h4 class="fw-bold mb-0">{{ $stats['attempts'] }}</h4>
            </div>
        </div>
    </div>

    <div class="row g-3 fade-rise">
        <div class="col-lg-7">
            <div class="card rounded-4 p-3 h-100">
                <h5 class="fw-semibold mb-3">Recent attempts</h5>
                <div class="list-group list-group-flush">
                    @foreach ($recentAttempts as $attempt)
                        <div class="list-group-item bg-transparent text-white d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fw-semibold">{{ $attempt->user->name ?? 'User' }}</div>
                                <small class="text-secondary">{{ $attempt->quiz->title ?? 'Quiz' }}</small>
                            </div>
                            <div class="text-end">
                                <div class="text-info fw-bold">{{ $attempt->percentage }}%</div>
                                <small class="text-secondary">{{ $attempt->finished_at?->diffForHumans() }}</small>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card rounded-4 p-3 h-100">
                <h5 class="fw-semibold mb-3">Most played quizzes</h5>
                @foreach ($popularQuizzes as $quiz)
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <div class="fw-semibold">{{ Str::limit($quiz->title, 40) }}</div>
                            <small class="text-secondary text-uppercase">{{ $quiz->category }}</small>
                        </div>
                        <span class="badge text-bg-dark">{{ $quiz->attempts_count }} attempts</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
