@extends('layouts.app')

@section('content')
<h2>My Profile</h2>
<div class="card">
    <div class="card-body">
        <p><strong>Name:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Registration Number:</strong> {{ $user->registration_number ?? '-' }}</p>
        <p><strong>Role:</strong> {{ ucfirst($user->role) }}</p>
    </div>
</div>
@endsection