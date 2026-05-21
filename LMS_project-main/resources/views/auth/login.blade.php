@extends('layouts.app')

@section('content')
<div class="auth-shell">
    <div class="gradient-blob"></div>
    <div class="row justify-content-center">
        <div class="col-lg-6 col-xl-5">
            <div class="auth-card shadow-lg border-0">
                <div class="card-body p-4 p-md-5">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div>
                            <p class="text-muted text-uppercase fw-semibold mb-1 small">Welcome back</p>
                            <h3 class="fw-bold mb-0">Login</h3>
                        </div>
                        <span class="badge bg-primary-soft text-primary fw-semibold">Secure Access</span>
                    </div>

                    <form method="POST" action="{{ route('login.submit') }}" class="needs-validation" novalidate>
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required autofocus>
                            </div>
                            @error('email')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                <input type="password" name="password" id="password" class="form-control" required>
                            </div>
                            @error('password')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Remember me</label>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">Login</button>
                    </form>
                    <p class="mt-3 mb-0 text-center">Don't have an account?
                        <a href="{{ route('register') }}" class="link-primary">Register here</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@section('styles')
<style>
    :root {
        --surface: #ffffff;
        --muted: #6c757d;
        --primary-soft: rgba(13, 110, 253, 0.12);
        --border: rgba(0, 0, 0, 0.07);
        --shadow: 0 1rem 2.5rem rgba(0, 0, 0, 0.1);
    }
    body.dark-mode :root,
    body.dark-mode {
        --surface: #181a1f;
        --muted: #adb5bd;
        --primary-soft: rgba(59, 130, 246, 0.18);
        --border: rgba(255, 255, 255, 0.08);
        --shadow: 0 1rem 2.5rem rgba(0, 0, 0, 0.5);
    }
    .auth-shell {
        position: relative;
        min-height: calc(100vh - 120px);
        display: flex;
        align-items: center;
    }
    .auth-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 18px;
        box-shadow: var(--shadow);
        position: relative;
        overflow: hidden;
    }
    .gradient-blob {
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at 20% 20%, rgba(13, 110, 253, 0.18), transparent 35%),
                    radial-gradient(circle at 80% 0%, rgba(111, 66, 193, 0.12), transparent 40%),
                    radial-gradient(circle at 50% 80%, rgba(25, 135, 84, 0.12), transparent 45%);
        filter: blur(20px);
        z-index: 0;
        opacity: 0.8;
    }
    .auth-shell .row {
        position: relative;
        z-index: 1;
        width: 100%;
    }
    .badge.bg-primary-soft {
        background: var(--primary-soft);
        border: 1px solid var(--border);
    }
    .input-group-text {
        background: transparent;
        border-color: var(--border);
    }
    .form-control {
        border-color: var(--border);
        background: rgba(255, 255, 255, 0.9);
    }
    body.dark-mode .form-control {
        background: rgba(24, 26, 31, 0.85);
        color: #f8f9fa;
    }
    body.dark-mode .auth-card {
        background: #1f2229;
    }
</style>
<!-- Bootstrap icons for a subtle visual lift -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
@endsection
@endsection
