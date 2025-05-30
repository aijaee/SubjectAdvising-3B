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
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('students', StudentController::class);
Route::resource('courses', CourseController::class);
Route::resource('enrollments', EnrollmentController::class);
Route::resource('marks', MarkController::class);
Route::resource('users', UserController::class);


Route::middleware(['auth'])->group(function () {
    Route::get('/student/enrollments', function () {
        if (Auth::user()->user_role !== 'Student') {
            abort(403);
        }
        return app(\App\Http\Controllers\StudentController::class)->enrollments();
    })->name('student.enrollments');

    Route::get('/student/marks', function () {
        if (Auth::user()->user_role !== 'Student') {
            abort(403);
        }
        return app(\App\Http\Controllers\StudentController::class)->marks();
    })->name('student.marks');
});


