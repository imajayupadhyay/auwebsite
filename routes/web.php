<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\ServiceInquiryController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [HomeController::class, 'index']);

Route::get('/courses',       [CoursesController::class, 'index']);
Route::get('/courses/{slug}',[CoursesController::class, 'show'])->where('slug', '[a-z0-9-]+');

Route::get('/portfolio', function () {
    return Inertia::render('Portfolio/Index');
});

Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::post('/service-inquiry', [ServiceInquiryController::class, 'store'])->name('service-inquiry.store');
Route::post('/newsletter', [NewsletterController::class, 'store'])->name('newsletter.store');

Route::get('/services', function () {
    return Inertia::render('Services/Index');
});

Route::get('/sitemap.xml', [SitemapController::class, 'index']);
