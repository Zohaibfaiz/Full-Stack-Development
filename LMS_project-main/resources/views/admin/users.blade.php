@extends('layouts.app')

@section('content')
<h2>Manage Users</h2>
<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Registration Number</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ ucfirst($user->role) }}</td>
                <td>{{ $user->registration_number ?? '-' }}</td>
                <td>
                    @if($user->role !== 'admin')
                        <form method="POST" action="{{ route('admin.users.delete', $user->id) }}" onsubmit="return confirm('Are you sure you want to delete this user?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
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