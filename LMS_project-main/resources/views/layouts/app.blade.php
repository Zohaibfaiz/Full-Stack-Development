<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'LMS') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Dark mode styles */
        body.dark-mode {
            background-color: #0f1115;
            color: #f1f3f5;
        }
        body.dark-mode .navbar {
            background-color: #151820;
        }
        body.dark-mode .navbar.navbar-light .navbar-brand,
        body.dark-mode .navbar.navbar-light .navbar-nav .nav-link,
        body.dark-mode .navbar.navbar-light .navbar-nav .nav-link:visited {
            color: #e9ecef !important;
        }
        body.dark-mode .navbar.navbar-light .navbar-nav .nav-link:hover,
        body.dark-mode .navbar.navbar-light .navbar-nav .nav-link:focus {
            color: #51cf66 !important;
        }
        body.dark-mode .navbar.navbar-light .navbar-nav .nav-link.active {
            color: #51cf66 !important;
        }
        body.dark-mode .navbar.navbar-dark .navbar-nav .nav-link,
        body.dark-mode .navbar.navbar-dark .navbar-brand {
            color: #e9ecef;
        }
        body.dark-mode .navbar .btn {
            color: #e9ecef;
            border-color: rgba(255, 255, 255, 0.35);
        }
        body.dark-mode .navbar .btn:hover {
            color: #0f1115;
            background-color: #e9ecef;
            border-color: #e9ecef;
        }
        body.dark-mode .navbar-light .navbar-toggler-icon {
            filter: invert(1);
        }
        body.dark-mode .navbar-light .navbar-toggler {
            border-color: rgba(255, 255, 255, 0.25);
        }
        body.dark-mode .card,
        body.dark-mode .alert {
            background-color: #181b24;
            color: #f1f3f5;
            border-color: rgba(255, 255, 255, 0.08);
        }
        body.dark-mode .list-group-item,
        body.dark-mode .table {
            background-color: #181b24;
            color: #f1f3f5;
        }
        body.dark-mode .form-control,
        body.dark-mode .form-select {
            background-color: #1f2330;
            color: #f8f9fa;
            border-color: rgba(255, 255, 255, 0.12);
        }
        body.dark-mode .form-control::placeholder {
            color: #c6ccd2;
        }
    </style>
    @yield('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light px-3">
        <a class="navbar-brand" href="#">{{ config('app.name', 'LMS') }}</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                @auth
                    @if(auth()->user()->role === 'student')
                        <li class="nav-item"><a class="nav-link" href="{{ route('student.dashboard') }}">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('student.courses') }}">Courses</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('student.assignments') }}">Assignments</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('student.quizzes') }}">Quizzes</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('student.resources') }}">Resources</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('student.attendance') }}">Attendance</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('student.marks') }}">Marks</a></li>
                    @elseif(auth()->user()->role === 'teacher')
                        <li class="nav-item"><a class="nav-link" href="{{ route('teacher.dashboard') }}">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('teacher.courses') }}">Courses</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('teacher.course-requests') }}">Course Requests</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('teacher.assignments') }}">Assignments</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('teacher.quizzes') }}">Quizzes</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('teacher.resources') }}">Resources</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('teacher.attendance') }}">Attendance</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('teacher.marks') }}">Marks</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('teacher.submissions') }}">Submissions</a></li>
                    @elseif(auth()->user()->role === 'admin')
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.users') }}">Users</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.courses') }}">Courses</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.requests') }}">Requests</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.course.proposals') }}">Course Proposals</a></li>
                    @endif
                @endauth
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <button class="btn btn-sm btn-outline-secondary me-2" id="darkToggle">Toggle Dark Mode</button>
                </li>
                @auth
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-danger">Logout</button>
                        </form>
                    </li>
                @else
                    <li class="nav-item"><a class="btn btn-sm btn-outline-primary me-2" href="{{ route('login') }}">Login</a></li>
                    <li class="nav-item"><a class="btn btn-sm btn-primary" href="{{ route('register') }}">Sign Up</a></li>
                @endauth
            </ul>
        </div>
    </nav>
    <div class="container mt-4">
        @if(session('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Dark mode toggle using localStorage
        const toggleBtn = document.getElementById('darkToggle');
        const navbar = document.querySelector('nav.navbar');
        function updateToggleLabel(isDark) {
            if (!toggleBtn) return;
            toggleBtn.textContent = isDark ? 'Toggle Light Mode' : 'Toggle Dark Mode';
            toggleBtn.setAttribute('aria-label', toggleBtn.textContent);
        }
        function applyNavbarMode(isDark) {
            if (!navbar) return;
            if (isDark) {
                navbar.classList.remove('navbar-light', 'bg-light');
                navbar.classList.add('navbar-dark');
            } else {
                navbar.classList.remove('navbar-dark');
                navbar.classList.add('navbar-light', 'bg-light');
            }
        }
        function applyDarkMode() {
            const isDark = localStorage.getItem('dark-mode') === 'dark';
            if (isDark) {
                document.body.classList.add('dark-mode');
            } else {
                document.body.classList.remove('dark-mode');
            }
            updateToggleLabel(isDark);
            applyNavbarMode(isDark);
        }
        toggleBtn?.addEventListener('click', function () {
            document.body.classList.toggle('dark-mode');
            localStorage.setItem('dark-mode', document.body.classList.contains('dark-mode') ? 'dark' : 'light');
            const isDark = document.body.classList.contains('dark-mode');
            updateToggleLabel(isDark);
            applyNavbarMode(isDark);
        });
        // Apply dark mode on page load
        applyDarkMode();
    </script>
    @yield('scripts')
</body>
</html>
