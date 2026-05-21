@extends('layouts.app')

@section('content')
<h2>Assign Marks</h2>
@if($courses->isEmpty())
    <p>You don't have any courses assigned.</p>
@else
    <div class="accordion" id="marksAccordion">
        @foreach($courses as $course)
            <div class="accordion-item">
                <h2 class="accordion-header" id="marksHeading{{ $course->id }}">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#marksCollapse{{ $course->id }}" aria-expanded="false" aria-controls="marksCollapse{{ $course->id }}">
                        {{ $course->name }} ({{ $course->students->count() }} students)
                    </button>
                </h2>
                <div id="marksCollapse{{ $course->id }}" class="accordion-collapse collapse" aria-labelledby="marksHeading{{ $course->id }}" data-bs-parent="#marksAccordion">
                    <div class="accordion-body">
                        <form method="POST" action="{{ route('teacher.marks') }}">
                            @csrf
                            <input type="hidden" name="course_id" value="{{ $course->id }}">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Student</th>
                                        <th>Marks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($course->students as $student)
                                        <tr>
                                            <td>{{ $student->name }}</td>
                                            <td>
                                                <input type="number" name="marks[{{ $student->id }}]" class="form-control" min="0" max="100" value="{{ $student->marks->firstWhere('course_id', $course->id)->marks ?? '' }}">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <button type="submit" class="btn btn-success">Save Marks</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection