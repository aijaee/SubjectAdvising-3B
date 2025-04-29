<?php

use Illuminate\Support\Facades\Route;

Route::get('/login', 'App\Http\Controllers\LoginController@showLoginForm')->name('login');
Route::post('/login', 'App\Http\Controllers\LoginController@login');

// Add the register route
Route::get('/register', 'App\Http\Controllers\RegisterController@showRegistrationForm')->name('register');
Route::post('/register', 'App\Http\Controllers\RegisterController@register');


Route::get('/dashboard', 'App\Http\Controllers\DashboardController@index')->name('dashboard');
