@extends('layouts.app')

@section('content')
    <div class="hero-surface rounded-4 p-4 p-lg-5 mb-4 fade-rise">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <p class="text-secondary mb-1 text-uppercase small">Live rankings</p>
                <h2 class="fw-bold mb-0">Leaderboard</h2>
            </div>
            <a href="{{ route('quizzes.index') }}" class="btn btn-accent">Play a new quiz</a>
        </div>
        <div class="d-flex flex-wrap gap-2 mt-3">
            <div class="pill"><i class="bi bi-trophy-fill text-warning"></i> Top {{ $leaders->count() }} players</div>
            <div class="pill"><i class="bi bi-clock-history text-info"></i> {{ $recent->count() }} recent finishes</div>
            <div class="pill"><i class="bi bi-activity text-success"></i> Real-time updates</div>
        </div>
        @auth
            <div class="stat-chip d-inline-flex align-items-center gap-3 mt-3 flex-wrap">
                <div>
                    <div class="text-secondary small">Your best pulse</div>
                    <div class="h5 fw-semibold mb-0">{{ $userBest ? $userBest . '%' : '—' }}</div>
                </div>
                <div class="vr opacity-50"></div>
                <div>
                    <div class="text-secondary small">Current rank</div>
                    <div class="h6 fw-semibold mb-0">{{ $userRank ?? '—' }}</div>
                </div>
                <span class="badge badge-glow">Live</span>
            </div>
        @endauth
    </div>

    <div class="row g-3 fade-rise">
        <div class="col-lg-7">
            <div class="card rounded-4 p-3 p-lg-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <p class="text-secondary mb-1 text-uppercase small">Top IQ climbs</p>
                        <h5 class="fw-semibold mb-0">Best score per user</h5>
                    </div>
                    <span class="badge badge-soft">20 slots</span>
                </div>
                <div class="table-responsive">
                    <table class="table table-dark table-sm align-middle rounded-4 overflow-hidden">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>Best %</th>
                                <th>Score</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($leaders as $index => $row)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $row->user->name ?? 'Unknown' }}</td>
                                    <td class="text-info fw-semibold">{{ $row->best_percentage }}%</td>
                                    <td>{{ $row->best_score }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-secondary">No attempts yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card rounded-4 p-3 p-lg-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <p class="text-secondary mb-1 text-uppercase small">Recent finishes</p>
                        <h5 class="fw-semibold mb-0">Live feed</h5>
                    </div>
                    <span class="badge badge-soft">Instant</span>
                </div>
                <div class="list-group list-group-flush">
                    @forelse ($recent as $attempt)
                        <div class="list-group-item bg-transparent text-white d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fw-semibold">{{ $attempt->user->name ?? 'Player' }}</div>
                                <small class="text-secondary">{{ $attempt->quiz->title ?? 'Quiz' }}</small>
                            </div>
                            <div class="text-end">
                                <div class="fw-bold text-info">{{ $attempt->percentage }}%</div>
                                <small class="text-secondary">{{ $attempt->finished_at?->diffForHumans() }}</small>
                            </div>
                        </div>
                    @empty
                        <p class="text-secondary mb-0">Play a game to populate the feed.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
