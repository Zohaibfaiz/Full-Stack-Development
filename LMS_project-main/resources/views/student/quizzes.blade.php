@extends('layouts.app')

@section('content')
<h2>Quizzes</h2>
<div class="alert alert-secondary d-flex justify-content-between align-items-center">
    <div>
        <div class="fw-semibold">Course: {{ $selectedCourse->name }}</div>
        <small>Change the active course from the Courses page.</small>
    </div>
    <a class="btn btn-sm btn-outline-primary" href="{{ route('student.courses') }}">Change course</a>
</div>
<table class="table table-striped align-middle">
    <thead>
        <tr>
            <th>Course</th>
            <th>Title</th>
            <th>Due Date</th>
            <th>File</th>
            <th>Submit</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($quizzes as $quiz)
            @php $submitted = $quiz->submissions->isNotEmpty(); @endphp
            <tr>
                <td>{{ $quiz->course->name ?? '' }}</td>
                <td>{{ $quiz->title }}</td>
                <td>{{ $quiz->due_date ? \Carbon\Carbon::parse($quiz->due_date)->format('Y-m-d') : '-' }}</td>
                <td>
                    @if($quiz->file_path)
                        <a href="{{ asset('storage/' . $quiz->file_path) }}" class="btn btn-sm btn-outline-primary" download>Download</a>
                    @else
                        - 
                    @endif
                </td>
                <td>
                    @if(! $submitted)
                        <form method="POST" action="{{ route('student.quiz.submit', $quiz->id) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="input-group input-group-sm">
                                <input type="file" name="file" class="form-control form-control-sm" required>
                                <button class="btn btn-sm btn-success" type="submit">Upload</button>
                            </div>
                        </form>
                    @else
                        <span class="text-muted small">-</span>
                    @endif
                </td>
                <td>
                    @if($submitted)
                        <strong class="text-success">Submitted</strong>
                    @else
                        <span class="text-warning">Pending</span>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
