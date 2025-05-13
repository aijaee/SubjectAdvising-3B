<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\MarkController;
use App\Http\Controllers\UserController;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Add the register route
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Dashboard route
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Additional routes for sidebar links
Route::resource('students', StudentController::class);
// Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
// Route::get('/enrollments', [EnrollmentController::class, 'index'])->name('enrollments.index');
// Route::get('/marks', [MarkController::class, 'index'])->name('marks.index');
// Route::get('/users', [UserController::class, 'index'])->name('users.index');
