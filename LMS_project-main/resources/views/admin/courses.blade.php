@extends('layouts.app')

@section('content')
<h2>Manage Courses</h2>

<div class="row">
    <div class="col-md-6">
        <h4>Create / Edit Course</h4>
        <form method="POST" action="{{ route('admin.courses.save') }}">
            @csrf
            <input type="hidden" name="course_id" id="course_id" value="">
            <div class="mb-3">
                <label for="name" class="form-label">Course Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
                @error('name')<span class="text-danger small">{{ $message }}</span>@enderror
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description"></textarea>
                @error('description')<span class="text-danger small">{{ $message }}</span>@enderror
            </div>
            <div class="mb-3">
                <label for="teacher_id" class="form-label">Assign Teacher</label>
                <select name="teacher_id" id="teacher_id" class="form-select" required>
                    @foreach($teachers as $teacher)
                        <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                    @endforeach
                </select>
                @error('teacher_id')<span class="text-danger small">{{ $message }}</span>@enderror
            </div>
            <button type="submit" class="btn btn-success">Save Course</button>
        </form>
    </div>
    <div class="col-md-6">
        <h4>Existing Courses</h4>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Teacher</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($courses as $course)
                    <tr>
                        <td>{{ $course->id }}</td>
                        <td>{{ $course->name }}</td>
                        <td>{{ $course->teacher->name ?? '' }}</td>
                        <td>
                            <form method="POST" action="{{ route('admin.courses.delete', $course->id) }}" onsubmit="return confirm('Are you sure you want to delete this course?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection