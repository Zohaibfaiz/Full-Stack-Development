@extends('layouts.app')

@section('content')
<h2>Marks Summary</h2>
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
            <th>Course</th>
            <th>Marks</th>
            <th>Remarks</th>
        </tr>
    </thead>
    <tbody>
        @foreach($marks as $mark)
            <tr>
                <td>{{ $mark->course->name ?? '' }}</td>
                <td>{{ $mark->marks }}</td>
                <td>{{ $mark->remarks }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
