<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        $courses = Course::withCount('modules')
            ->orderBy('sort_order')
            ->get(['id', 'code', 'slug', 'title', 'subtitle', 'icon', 'dot_color', 'level', 'hours', 'available']);

        return Inertia::render('Home/Index', [
            'courses' => $courses,
        ]);
    }
}
