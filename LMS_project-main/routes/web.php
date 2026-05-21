<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;

// Landing page redirects users to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
});

// Logout route
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Routes accessible to authenticated users only
Route::middleware('auth')->group(function () {
    // Student routes
    Route::middleware('role:student')->prefix('student')->name('student.')->group(function () {
        Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');
        Route::get('/courses', [StudentController::class, 'courses'])->name('courses');
        Route::post('/courses/request', [StudentController::class, 'requestCourse'])->name('courses.request');
        Route::post('/courses/select', [StudentController::class, 'selectCourse'])->name('courses.select');
        Route::get('/attendance', [StudentController::class, 'attendance'])->name('attendance');
        Route::get('/marks', [StudentController::class, 'marks'])->name('marks');
        Route::get('/resources', [StudentController::class, 'resources'])->name('resources');
        Route::get('/assignments', [StudentController::class, 'assignments'])->name('assignments');
        Route::post('/assignments/{assignment}/submit', [StudentController::class, 'submitAssignment'])->name('assignment.submit');
        Route::get('/quizzes', [StudentController::class, 'quizzes'])->name('quizzes');
        Route::post('/quizzes/{quiz}/submit', [StudentController::class, 'submitQuiz'])->name('quiz.submit');
        Route::get('/profile', [StudentController::class, 'profile'])->name('profile');
    });

    // Teacher routes
    Route::middleware('role:teacher')->prefix('teacher')->name('teacher.')->group(function () {
        Route::get('/dashboard', [TeacherController::class, 'dashboard'])->name('dashboard');
        Route::get('/courses', [TeacherController::class, 'courses'])->name('courses');
        Route::get('/course-requests', [TeacherController::class, 'courseRequests'])->name('course-requests');
        Route::post('/course-requests', [TeacherController::class, 'storeCourseRequest'])->name('course-requests.store');
        // Resources
        Route::get('/resources', [TeacherController::class, 'resources'])->name('resources');
        Route::get('/resources/create', [TeacherController::class, 'createResource'])->name('resource.create');
        Route::post('/resources', [TeacherController::class, 'storeResource'])->name('resource.store');
        // Assignments
        Route::get('/assignments', [TeacherController::class, 'assignments'])->name('assignments');
        Route::get('/assignments/create', [TeacherController::class, 'createAssignment'])->name('assignment.create');
        Route::post('/assignments', [TeacherController::class, 'storeAssignment'])->name('assignment.store');
        // Quizzes
        Route::get('/quizzes', [TeacherController::class, 'quizzes'])->name('quizzes');
        Route::get('/quizzes/create', [TeacherController::class, 'createQuiz'])->name('quiz.create');
        Route::post('/quizzes', [TeacherController::class, 'storeQuiz'])->name('quiz.store');
        // Attendance & Marks
        Route::match(['get','post'], '/attendance', [TeacherController::class, 'attendance'])->name('attendance');
        Route::match(['get','post'], '/marks', [TeacherController::class, 'marks'])->name('marks');
        // Student submissions
        Route::get('/submissions', [TeacherController::class, 'submissions'])->name('submissions');
    });

    // Admin routes
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        // Users management
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('users.delete');
        // Courses management
        Route::get('/courses', [AdminController::class, 'courses'])->name('courses');
        Route::post('/courses', [AdminController::class, 'saveCourse'])->name('courses.save');
        Route::delete('/courses/{id}', [AdminController::class, 'deleteCourse'])->name('courses.delete');
        // Course requests
        Route::get('/requests', [AdminController::class, 'courseRequests'])->name('requests');
        Route::post('/requests/{id}/approve', [AdminController::class, 'approveRequest'])->name('request.approve');
        Route::post('/requests/{id}/reject', [AdminController::class, 'rejectRequest'])->name('request.reject');
        // Course proposals (new course creation requests from teachers)
        Route::get('/course-proposals', [AdminController::class, 'courseProposals'])->name('course.proposals');
        Route::post('/course-proposals/{id}/approve', [AdminController::class, 'approveCourseProposal'])->name('course.proposals.approve');
        Route::post('/course-proposals/{id}/reject', [AdminController::class, 'rejectCourseProposal'])->name('course.proposals.reject');
    });
});
