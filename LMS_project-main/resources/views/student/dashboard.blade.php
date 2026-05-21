@extends('layouts.app')

@section('content')
<h2>Welcome, {{ $user->name }}</h2>
<div class="row mt-3">
    <div class="col-md-4">
        <div class="card text-bg-primary mb-3">
            <div class="card-body">
                <h5 class="card-title">Enrolled Courses</h5>
                <p class="card-text display-5">{{ $coursesCount }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-bg-success mb-3">
            <div class="card-body">
                <h5 class="card-title">Assignments</h5>
                <p class="card-text display-5">{{ $assignmentsCount }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-bg-warning mb-3">
            <div class="card-body">
                <h5 class="card-title">Quizzes</h5>
                <p class="card-text display-5">{{ $quizzesCount }}</p>
            </div>
        </div>
    </div>
</div>
@endsection