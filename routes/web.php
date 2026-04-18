<?php

use App\Http\Controllers\ContactController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home/Index');
});

Route::get('/courses', function (Request $request) {
    return Inertia::render('Courses/Index', [
        'search' => (string) $request->query('search', ''),
    ]);
});

Route::get('/portfolio', function () {
    return Inertia::render('Portfolio/Index');
});

Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('/services', function () {
    return Inertia::render('Services/Index');
});

Route::get('/courses/{slug}', function (string $slug) {
    return Inertia::render('Courses/Show', ['slug' => $slug]);
})->where('slug', '[a-z0-9-]+');
