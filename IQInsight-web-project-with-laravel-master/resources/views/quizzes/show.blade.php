@extends('layouts.app')

@section('content')
    @php $result = session('result'); @endphp
    <div class="row g-4 fade-rise">
        <div class="col-lg-8">
            <div class="hero-surface rounded-4 p-4 p-lg-5 mb-3">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-2">
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <span class="badge badge-glow text-uppercase">{{ $quiz->category }}</span>
                        <span class="pill"><i class="bi bi-graph-up-arrow text-info"></i>{{ ucfirst($quiz->difficulty) }}</span>
                        <span class="pill"><i class="bi bi-clock text-warning"></i>{{ $quiz->time_limit_seconds ?? '120' }}s</span>
                        <span class="pill"><i class="bi bi-question-circle text-success"></i>{{ $quiz->question_count ?: $quiz->questions->count() }} questions</span>
                    </div>
                </div>
                <h2 class="fw-bold">{{ $quiz->title }}</h2>
                <p class="text-secondary mb-0">{{ $quiz->description }}</p>
            </div>

            @if ($result)
                <div class="alert alert-success glass border-0 fade-rise in-view">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div>
                            <div class="fw-semibold">Your latest IQ pulse: {{ $result['percentage'] }}% ({{ $result['label'] }})</div>
                            <div class="text-secondary small">Score {{ $result['score'] }} / {{ $result['max'] }} | Estimated IQ {{ $result['iq'] }}</div>
                        </div>
                        <a href="{{ route('leaderboard') }}" class="btn btn-sm btn-outline-light">See leaderboard</a>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('quizzes.attempt', $quiz) }}" class="fade-rise">
                @csrf
                <input type="hidden" id="timeSpent" name="time_spent_seconds" value="0">
                @foreach ($quiz->questions as $index => $question)
                    <div class="card rounded-4 p-3 p-md-4 mb-3 border-0">
                        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                            <div class="fw-semibold">Q{{ $index + 1 }}. {{ $question->prompt }}</div>
                            <span class="badge badge-soft text-uppercase">{{ $question->type }}</span>
                        </div>
                        @if ($question->options)
                            <div class="row g-2">
                                @foreach ($question->options as $key => $option)
                                    <div class="col-md-6">
                                        <label class="d-flex align-items-center gap-3 p-3 rounded-3 border border-dark w-100 hover-shadow" style="cursor:pointer;">
                                            @if ($question->type === 'multi')
                                                <input type="checkbox" class="form-check-input mt-0" name="answers[{{ $question->id }}][]" value="{{ $key }}">
                                            @else
                                                <input type="radio" class="form-check-input mt-0" name="answers[{{ $question->id }}][]" value="{{ $key }}">
                                            @endif
                                            <div>
                                                <div class="text-white fw-semibold">{{ $key }}. {{ $option }}</div>
                                            </div>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <input type="text" class="form-control bg-dark text-white border-dark" placeholder="Type your answer" name="answers[{{ $question->id }}][]">
                        @endif
                    </div>
                @endforeach

                @auth
                    <button class="btn btn-accent btn-lg w-100 mt-3">Submit & calculate IQ</button>
                @else
                    <div class="alert alert-info glass border-0">
                        Please <a href="{{ route('login') }}" class="text-white fw-semibold">login</a> or
                        <a href="{{ route('register') }}" class="text-white fw-semibold">sign up</a> to play and post your score.
                    </div>
                @endauth
            </form>
        </div>
        <div class="col-lg-4">
            <div class="card rounded-4 p-3 mb-3 border-0">
                <h6 class="fw-semibold mb-2">Quick facts</h6>
                <div class="d-flex flex-column gap-2 text-secondary small">
                    <div><i class="bi bi-lightbulb me-2 text-info"></i>Adaptive difficulty with each play</div>
                    <div><i class="bi bi-repeat me-2 text-info"></i>Fresh order every attempt</div>
                    <div><i class="bi bi-trophy me-2 text-info"></i>Scores push to the live leaderboard</div>
                </div>
            </div>
            <div class="card rounded-4 p-3 border-0">
                <h6 class="fw-semibold mb-3">More to explore</h6>
                @foreach ($alternatives as $alt)
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <div class="fw-semibold">{{ $alt->title }}</div>
                            <small class="text-secondary text-uppercase">{{ $alt->category }}</small>
                        </div>
                        <a href="{{ route('quizzes.show', $alt) }}" class="btn btn-sm btn-outline-light">Play</a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    let elapsed = 0;
    const timer = setInterval(() => {
        elapsed += 1;
        const field = document.getElementById('timeSpent');
        if (field) field.value = elapsed;
    }, 1000);
</script>
@endpush
