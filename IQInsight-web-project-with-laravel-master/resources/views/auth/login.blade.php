@extends('layouts.app')

@section('content')
    <div class="row justify-content-center fade-rise">
        <div class="col-md-6">
            <div class="card rounded-4 p-4">
                <h3 class="fw-bold mb-3">Login</h3>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label text-secondary">Email</label>
                        <input type="email" name="email" class="form-control bg-dark text-white border-dark" required value="{{ old('email') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-secondary">Password</label>
                        <input type="password" name="password" class="form-control bg-dark text-white border-dark" required>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label text-secondary" for="remember">Remember me</label>
                    </div>
                    <button class="btn btn-accent w-100 mb-3">Login & play</button>
                </form>
                <p class="text-secondary mb-0">No account? <a href="{{ route('register') }}">Sign up</a></p>
            </div>
        </div>
    </div>
@endsection
