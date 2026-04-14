<?php

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

Route::get('/courses/{slug}', function (string $slug) {
    return Inertia::render('Courses/Show', ['slug' => $slug]);
})->where('slug', '[a-z0-9-]+');
