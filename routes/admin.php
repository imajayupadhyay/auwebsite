<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\ContactsController;
use App\Http\Controllers\Admin\CourseLessonsController;
use App\Http\Controllers\Admin\CourseModulesController;
use App\Http\Controllers\Admin\CoursesController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InquiriesController;
use App\Http\Controllers\Admin\NewsletterController as AdminNewsletterController;
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

        // Service Inquiries
        Route::get('/inquiries', [InquiriesController::class, 'index'])->name('inquiries.index');
        Route::patch('/inquiries/{inquiry}/toggle-read', [InquiriesController::class, 'toggleRead'])->name('inquiries.toggleRead');
        Route::delete('/inquiries/{inquiry}', [InquiriesController::class, 'destroy'])->name('inquiries.destroy');

        // Newsletter
        Route::get('/newsletter', [AdminNewsletterController::class, 'index'])->name('newsletter.index');
        Route::patch('/newsletter/{subscriber}/toggle-active', [AdminNewsletterController::class, 'toggleActive'])->name('newsletter.toggleActive');
        Route::delete('/newsletter/{subscriber}', [AdminNewsletterController::class, 'destroy'])->name('newsletter.destroy');

        // Users
        Route::get('/users', [UsersController::class, 'index'])->name('users.index');
        Route::post('/users', [UsersController::class, 'store'])->name('users.store');
        Route::patch('/users/{user}', [UsersController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UsersController::class, 'destroy'])->name('users.destroy');

        // Categories
        Route::get('/categories', [CategoriesController::class, 'index'])->name('categories.index');
        Route::post('/categories', [CategoriesController::class, 'store'])->name('categories.store');
        Route::patch('/categories/{category}', [CategoriesController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{category}', [CategoriesController::class, 'destroy'])->name('categories.destroy');

        // Courses
        Route::get('/courses', [CoursesController::class, 'index'])->name('courses.index');
        Route::get('/courses/create', [CoursesController::class, 'create'])->name('courses.create');
        Route::post('/courses', [CoursesController::class, 'store'])->name('courses.store');
        Route::get('/courses/{course}/edit', [CoursesController::class, 'edit'])->name('courses.edit');
        Route::patch('/courses/{course}', [CoursesController::class, 'update'])->name('courses.update');
        Route::delete('/courses/{course}', [CoursesController::class, 'destroy'])->name('courses.destroy');

        // Course modules
        Route::post('/courses/{course}/modules', [CourseModulesController::class, 'store'])->name('modules.store');
        Route::patch('/modules/{module}', [CourseModulesController::class, 'update'])->name('modules.update');
        Route::delete('/modules/{module}', [CourseModulesController::class, 'destroy'])->name('modules.destroy');

        // Course lessons
        Route::post('/modules/{module}/lessons', [CourseLessonsController::class, 'store'])->name('lessons.store');
        Route::patch('/lessons/{lesson}', [CourseLessonsController::class, 'update'])->name('lessons.update');
        Route::delete('/lessons/{lesson}', [CourseLessonsController::class, 'destroy'])->name('lessons.destroy');
    });
