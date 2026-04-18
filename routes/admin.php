<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

// Public — secret login URL
Route::get('/ajayupadhyay-secure-login', [AuthController::class, 'showLogin'])->name('admin.login');
Route::post('/ajayupadhyay-secure-login', [AuthController::class, 'login'])->name('admin.login.post');

// Protected admin area
Route::middleware('admin')
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    });
