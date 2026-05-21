@extends('layouts.app')

@section('content')
<h2>Student Submissions</h2>
<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Student</th>
            <th>Type</th>
            <th>Course</th>
            <th>Title</th>
            <th>Submitted At</th>
            <th>File</th>
            <th>Marks</th>
            <th>Feedback</th>
        </tr>
    </thead>
    <tbody>
        @foreach($submissions as $submission)
            <tr>
                <td>{{ $submission->id }}</td>
                <td>{{ $submission->student->name ?? '' }}</td>
                <td>{{ $submission->assignment ? 'Assignment' : 'Quiz' }}</td>
                <td>{{ $submission->assignment?->course->name ?? $submission->quiz?->course->name }}</td>
                <td>{{ $submission->assignment?->title ?? $submission->quiz?->title }}</td>
                <td>{{ \Carbon\Carbon::parse($submission->submitted_at)->format('Y-m-d H:i') }}</td>
                <td><a href="{{ asset('storage/' . $submission->file_path) }}" class="btn btn-sm btn-outline-primary" download>Download</a></td>
                <td>{{ $submission->marks ?? '-' }}</td>
                <td>{{ $submission->feedback ?? '-' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection