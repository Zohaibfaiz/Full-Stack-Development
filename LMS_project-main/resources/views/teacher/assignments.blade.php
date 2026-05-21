@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Assignments</h2>
    <a href="{{ route('teacher.assignment.create') }}" class="btn btn-primary">Create Assignment</a>
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
        @foreach($assignments as $assignment)
            <tr>
                <td>{{ $assignment->id }}</td>
                <td>{{ $assignment->course->name ?? '' }}</td>
                <td>{{ $assignment->title }}</td>
                <td>{{ $assignment->due_date ? \Carbon\Carbon::parse($assignment->due_date)->format('Y-m-d') : '-' }}</td>
                <td>
                    @if($assignment->file_path)
                        <a href="{{ asset('storage/' . $assignment->file_path) }}" class="btn btn-sm btn-outline-primary" download>Download</a>
                    @else
                        -
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection