@extends('layouts.app')

@section('content')
<h2>Your Courses</h2>
<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Students</th>
        </tr>
    </thead>
    <tbody>
        @foreach($courses as $course)
            <tr>
                <td>{{ $course->id }}</td>
                <td>{{ $course->name }}</td>
                <td>{{ $course->description }}</td>
                <td>{{ $course->students->count() }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection