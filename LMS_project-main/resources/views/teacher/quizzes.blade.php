@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Quizzes</h2>
    <a href="{{ route('teacher.quiz.create') }}" class="btn btn-primary">Create Quiz</a>
</div>
<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Course</th>
            <th>Title</th>
            <th>Due Date</th>
            <th>File</th>
        </tr>
    </thead>
    <tbody>
        @foreach($quizzes as $quiz)
            <tr>
                <td>{{ $quiz->id }}</td>
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
            </tr>
        @endforeach
    </tbody>
</table>
@endsection