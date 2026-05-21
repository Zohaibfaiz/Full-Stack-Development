@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Resources</h2>
    <a href="{{ route('teacher.resource.create') }}" class="btn btn-primary">Upload Resource</a>
</div>
<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Course</th>
            <th>Title</th>
            <th>File</th>
        </tr>
    </thead>
    <tbody>
        @foreach($resources as $resource)
            <tr>
                <td>{{ $resource->id }}</td>
                <td>{{ $resource->course->name ?? '' }}</td>
                <td>{{ $resource->title }}</td>
                <td><a href="{{ asset('storage/' . $resource->file_path) }}" class="btn btn-sm btn-outline-primary" download>Download</a></td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection