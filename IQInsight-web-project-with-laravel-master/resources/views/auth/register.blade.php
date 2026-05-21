@extends('layouts.app')

@section('content')
    <div class="row justify-content-center fade-rise">
        <div class="col-md-6">
            <div class="card rounded-4 p-4">
                <h3 class="fw-bold mb-3">Create account</h3>
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label text-secondary">Name</label>
                        <input type="text" name="name" class="form-control bg-dark text-white border-dark" required value="{{ old('name') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-secondary">Email</label>
                        <input type="email" name="email" class="form-control bg-dark text-white border-dark" required value="{{ old('email') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-secondary">Password</label>
                        <input type="password" name="password" class="form-control bg-dark text-white border-dark" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-secondary">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control bg-dark text-white border-dark" required>
                    </div>
                    <button class="btn btn-accent w-100 mb-3">Sign up & start playing</button>
                </form>
                <p class="text-secondary mb-0">Already have an account? <a href="{{ route('login') }}">Login</a></p>
            </div>
        </div>
    </div>
@endsection
