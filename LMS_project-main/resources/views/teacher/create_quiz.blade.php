@extends('layouts.app')

@section('content')
<h2>Create Quiz</h2>
<form method="POST" action="{{ route('teacher.quiz.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label for="course_id" class="form-label">Course</label>
        <select name="course_id" id="course_id" class="form-select" required>
            @foreach($courses as $course)
                <option value="{{ $course->id }}">{{ $course->name }}</option>
            @endforeach
        </select>
        @error('course_id')
            <span class="text-danger small">{{ $message }}</span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
        @error('title')
            <span class="text-danger small">{{ $message }}</span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control" id="description" name="description">{{ old('description') }}</textarea>
        @error('description')
            <span class="text-danger small">{{ $message }}</span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="file" class="form-label">File (optional)</label>
        <input type="file" class="form-control" id="file" name="file">
        @error('file')
            <span class="text-danger small">{{ $message }}</span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="due_date" class="form-label">Due Date</label>
        <input type="date" class="form-control" id="due_date" name="due_date" value="{{ old('due_date') }}">
        @error('due_date')
            <span class="text-danger small">{{ $message }}</span>
        @enderror
    </div>
    <button type="submit" class="btn btn-success">Create</button>
</form>
@endsection