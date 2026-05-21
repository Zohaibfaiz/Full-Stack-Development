@extends('layouts.app')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
    <div>
        <p class="text-muted text-uppercase fw-semibold small mb-1">Teacher</p>
        <h2 class="mb-0">Welcome, {{ $user->name }}</h2>
    </div>
    <a href="{{ route('teacher.course-requests') }}" class="btn btn-outline-primary btn-sm">Request a new course</a>
</div>
<div class="row">
    @foreach($courses as $course)
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header bg-primary text-white">{{ $course->name }}</div>
                <div class="card-body">
                    <p><strong>Assignments:</strong> {{ $course->assignments_count }}</p>
                    <p><strong>Quizzes:</strong> {{ $course->quizzes_count }}</p>
                    <p><strong>Resources:</strong> {{ $course->resources_count }}</p>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
