@extends('layouts.app')

@section('content')
<h2>Administrator Dashboard</h2>
<div class="row mt-3">
    <div class="col-md-3">
        <div class="card text-bg-primary mb-3">
            <div class="card-body">
                <h5 class="card-title">Students</h5>
                <p class="card-text display-6">{{ $studentsCount }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-bg-success mb-3">
            <div class="card-body">
                <h5 class="card-title">Teachers</h5>
                <p class="card-text display-6">{{ $teachersCount }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-bg-warning mb-3">
            <div class="card-body">
                <h5 class="card-title">Courses</h5>
                <p class="card-text display-6">{{ $coursesCount }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-bg-danger mb-3">
            <div class="card-body">
                <h5 class="card-title">Average Mark</h5>
                <p class="card-text display-6">{{ number_format($averageMark, 2) }}</p>
            </div>
        </div>
    </div>
</div>
@endsection