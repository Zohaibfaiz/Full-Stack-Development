@extends('layouts.app')

@section('content')
<h2>Record Attendance</h2>
@if($courses->isEmpty())
    <p>You don't have any courses assigned.</p>
@else
    <div class="accordion" id="attendanceAccordion">
        @foreach($courses as $course)
            <div class="accordion-item">
                <h2 class="accordion-header" id="heading{{ $course->id }}">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $course->id }}" aria-expanded="false" aria-controls="collapse{{ $course->id }}">
                        {{ $course->name }} ({{ $course->students->count() }} students)
                    </button>
                </h2>
                <div id="collapse{{ $course->id }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $course->id }}" data-bs-parent="#attendanceAccordion">
                    <div class="accordion-body">
                        <form method="POST" action="{{ route('teacher.attendance') }}">
                            @csrf
                            <input type="hidden" name="course_id" value="{{ $course->id }}">
                            <div class="mb-3">
                                <label for="date{{ $course->id }}" class="form-label">Date</label>
                                <input type="date" name="date" id="date{{ $course->id }}" class="form-control" value="{{ date('Y-m-d') }}" required>
                                @error('date')<span class="text-danger small">{{ $message }}</span>@enderror
                            </div>
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Student</th>
                                        <th>Present</th>
                                        <th>Absent</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($course->students as $student)
                                        <tr>
                                            <td>{{ $student->name }}</td>
                                            <td>
                                                <input type="radio" name="attendance[{{ $student->id }}]" value="present" checked>
                                            </td>
                                            <td>
                                                <input type="radio" name="attendance[{{ $student->id }}]" value="absent">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <button type="submit" class="btn btn-success">Save Attendance</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection