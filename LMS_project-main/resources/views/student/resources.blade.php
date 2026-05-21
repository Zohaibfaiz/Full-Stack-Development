@extends('layouts.app')

@section('content')
<h2>Learning Resources</h2>
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
            <th>Title</th>
            <th>Uploaded By</th>
            <th>File</th>
        </tr>
    </thead>
    <tbody>
        @foreach($resources as $resource)
            <tr>
                <td>{{ $resource->course->name ?? '' }}</td>
                <td>{{ $resource->title }}</td>
                <td>{{ $resource->uploader->name ?? '' }}</td>
                <td><a href="{{ asset('storage/' . $resource->file_path) }}" class="btn btn-sm btn-outline-primary" download>Download</a></td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
