<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ContactsController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UsersController;
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

        // Contacts
        Route::get('/contacts', [ContactsController::class, 'index'])->name('contacts.index');
        Route::patch('/contacts/{contact}/toggle-read', [ContactsController::class, 'toggleRead'])->name('contacts.toggleRead');
        Route::delete('/contacts/{contact}', [ContactsController::class, 'destroy'])->name('contacts.destroy');

        // Users
        Route::get('/users', [UsersController::class, 'index'])->name('users.index');
        Route::post('/users', [UsersController::class, 'store'])->name('users.store');
        Route::patch('/users/{user}', [UsersController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UsersController::class, 'destroy'])->name('users.destroy');
    });
