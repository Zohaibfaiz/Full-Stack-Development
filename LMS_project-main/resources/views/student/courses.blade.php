@extends('layouts.app')

@section('content')
<h2>Your Courses</h2>

@if($courses->isNotEmpty())
    @php $selectedCourse = $courses->firstWhere('id', $selectedCourseId); @endphp
    <div class="alert alert-info d-flex justify-content-between align-items-center">
        <div>
            <div class="fw-semibold">Active course: {{ $selectedCourse->name ?? 'Not selected' }}</div>
            <small>Assignments, quizzes, attendance, resources and marks will use this course.</small>
        </div>
        <a class="btn btn-sm btn-outline-primary" href="#set-course">Change</a>
    </div>

    <div id="set-course" class="card mb-4">
        <div class="card-body">
            <form method="POST" action="{{ route('student.courses.select') }}" class="row g-3 align-items-end">
                @csrf
                <div class="col-lg-6">
                    <label for="active_course_id" class="form-label">Choose active course</label>
                    <select name="course_id" id="active_course_id" class="form-select" required>
                        <option value="" disabled {{ $selectedCourseId ? '' : 'selected' }}>Select a course</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}" @selected($selectedCourseId === $course->id)>
                                {{ $course->name }} ({{ $course->teacher->name ?? 'N/A' }})
                            </option>
                        @endforeach
                    </select>
                    <div class="form-text">Required when you are enrolled in multiple courses.</div>
                </div>
                <div class="col-lg-3 d-grid">
                    <button type="submit" class="btn btn-primary">Set Active Course</button>
                </div>
            </form>
        </div>
    </div>
@endif

<table class="table table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Teacher</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($courses as $course)
            <tr>
                <td>{{ $course->id }}</td>
                <td>{{ $course->name }}</td>
                <td>{{ $course->teacher->name ?? 'N/A' }}</td>
                <td>{{ $course->pivot->status ?? 'approved' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<h3 class="mt-5">Request a New Course</h3>
<form method="POST" action="{{ route('student.courses.request') }}">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <label for="course_id" class="form-label">Select Course</label>
            <select name="course_id" id="course_id" class="form-select" required>
                @foreach($allCourses as $course)
                    <option value="{{ $course->id }}">{{ $course->name }} ({{ $course->teacher->name ?? 'N/A' }})</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6 d-flex align-items-end">
            <button type="submit" class="btn btn-primary">Send Request</button>
        </div>
    </div>
</form>
@endsection
