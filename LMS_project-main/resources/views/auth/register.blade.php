@extends('layouts.app')

@section('content')
<div class="auth-shell">
    <div class="gradient-blob"></div>
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="auth-card shadow-lg border-0">
                <div class="row g-0">
                    <div class="col-md-5 d-none d-md-block p-4 pe-md-0">
                        <div class="feature-panel h-100 rounded-start">
                            <p class="text-uppercase text-muted fw-semibold small mb-2">Create your account</p>
                            <h3 class="fw-bold mb-3">Join the LMS</h3>
                            <p class="text-muted mb-4">Access courses, manage resources, and keep your learning organized.</p>
                            <ul class="list-unstyled text-muted small">
                                <li class="d-flex align-items-center mb-2"><i class="bi bi-check-circle text-success me-2"></i>Role-aware dashboards</li>
                                <li class="d-flex align-items-center mb-2"><i class="bi bi-check-circle text-success me-2"></i>Secure authentication</li>
                                <li class="d-flex align-items-center"><i class="bi bi-check-circle text-success me-2"></i>Modern UI with light/dark mode</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="card-body p-4 p-md-5">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <div>
                                    <p class="text-muted text-uppercase fw-semibold mb-1 small">Getting started</p>
                                    <h3 class="fw-bold mb-0">Sign up</h3>
                                </div>
                                <span class="badge bg-success-soft text-success fw-semibold">Step 1 of 1</span>
                            </div>
                            <form method="POST" action="{{ route('register.submit') }}" class="needs-validation" novalidate>
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                                        @error('name')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
                                        @error('email')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" name="password" id="password" class="form-control" required>
                                        @error('password')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="role" class="form-label">Role</label>
                                        <select name="role" id="role" class="form-select" required>
                                            <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>Student</option>
                                            <option value="teacher" {{ old('role') == 'teacher' ? 'selected' : '' }}>Teacher</option>
                                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                        </select>
                                        @error('role')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="registration_number" class="form-label">Registration Number (students only)</label>
                                        <input type="text" name="registration_number" id="registration_number" class="form-control" value="{{ old('registration_number') }}">
                                        @error('registration_number')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success w-100 py-2 fw-semibold">Create account</button>
                            </form>
                            <p class="mt-3 mb-0 text-center">Already have an account?
                                <a href="{{ route('login') }}" class="link-primary">Login here</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('styles')
<style>
    :root {
        --surface: #ffffff;
        --surface-strong: #f8fafc;
        --text: #1f2937;
        --muted: #6c757d;
        --border: rgba(0, 0, 0, 0.08);
        --success-soft: rgba(25, 135, 84, 0.12);
        --shadow: 0 1rem 2.5rem rgba(0, 0, 0, 0.08);
    }
    body.dark-mode {
        --surface: #181b24;
        --surface-strong: #1f2330;
        --text: #f1f3f5;
        --muted: #c6ccd2;
        --border: rgba(255, 255, 255, 0.12);
        --success-soft: rgba(25, 135, 84, 0.18);
        --shadow: 0 1rem 2.5rem rgba(0, 0, 0, 0.45);
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
    .auth-card,
    .auth-card .card-body,
    .feature-panel {
        color: var(--text);
    }
    .gradient-blob {
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at 20% 20%, rgba(25, 135, 84, 0.18), transparent 35%),
                    radial-gradient(circle at 80% 0%, rgba(111, 66, 193, 0.12), transparent 40%),
                    radial-gradient(circle at 50% 80%, rgba(13, 110, 253, 0.12), transparent 45%);
        filter: blur(20px);
        z-index: 0;
        opacity: 0.8;
    }
    .auth-shell .row {
        position: relative;
        z-index: 1;
        width: 100%;
    }
    .feature-panel {
        background: linear-gradient(135deg, rgba(25, 135, 84, 0.12), rgba(13, 110, 253, 0.1));
        border: 1px solid var(--border);
        padding: 24px;
    }
    .badge.bg-success-soft {
        background: var(--success-soft);
        border: 1px solid var(--border);
    }
    .form-control, .form-select {
        border-color: var(--border);
        background: rgba(255, 255, 255, 0.96);
        color: var(--text);
    }
    .form-control::placeholder {
        color: var(--muted);
    }
    body.dark-mode .form-control,
    body.dark-mode .form-select {
        background: var(--surface-strong);
        color: #f8f9fa;
        border-color: var(--border);
    }
    body.dark-mode .form-control::placeholder {
        color: var(--muted);
    }
    body.dark-mode .auth-card,
    body.dark-mode .feature-panel {
        background: var(--surface);
        color: var(--text);
    }
    .text-muted, label, .card-body p {
        color: var(--muted) !important;
    }
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
@endsection
@endsection
