@extends('layouts.app')

@section('content')
<h2>Course Enrollment Requests</h2>
<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Student</th>
            <th>Course</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($requests as $request)
            <tr>
                <td>{{ $request->id }}</td>
                <td>{{ $request->student->name ?? '' }}</td>
                <td>{{ $request->course->name ?? '' }}</td>
                <td>{{ ucfirst($request->status) }}</td>
                <td>
                    @if($request->status === 'pending')
                        <form method="POST" action="{{ route('admin.request.approve', $request->id) }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success">Approve</button>
                        </form>
                        <form method="POST" action="{{ route('admin.request.reject', $request->id) }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-danger">Reject</button>
                        </form>
                    @else
                        -
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection