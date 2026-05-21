<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\QuizController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/quizzes', [QuizController::class, 'index'])->name('quizzes.index');
Route::get('/quizzes/{quiz:slug}', [QuizController::class, 'show'])->name('quizzes.show');
Route::post('/quizzes/{quiz:slug}/attempt', [QuizController::class, 'attempt'])
    ->name('quizzes.attempt')
    ->middleware('auth');

Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard');

Route::get('/admin', [AdminController::class, 'index'])
    ->name('admin.index')
    ->middleware('auth');
