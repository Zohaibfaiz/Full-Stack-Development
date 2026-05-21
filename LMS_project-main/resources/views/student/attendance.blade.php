@extends('layouts.app')

@section('content')
<h2>Attendance Records</h2>
<div class="alert alert-secondary d-flex justify-content-between align-items-center">
    <div>
        <div class="fw-semibold">Course: {{ $selectedCourse->name }}</div>
        <small>Change the active course from the Courses page.</small>
    </div>
    <a class="btn btn-sm btn-outline-primary" href="{{ route('student.courses') }}">Change course</a>
</div>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Date</th>
            <th>Course</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($attendances as $attendance)
            <tr>
                <td>{{ \Carbon\Carbon::parse($attendance->date)->format('Y-m-d') }}</td>
                <td>{{ $attendance->course->name ?? '' }}</td>
                <td>{{ ucfirst($attendance->status) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
