<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use Inertia\Inertia;

class CoursesController extends Controller
{
    public function index()
    {
        $courses = Course::with('categories')
            ->withCount('modules')
            ->orderBy('sort_order')
            ->get();

        $categories = Category::whereNull('parent_id')
            ->orderBy('sort_order')
            ->pluck('name');

        return Inertia::render('Courses/Index', [
            'courses'    => $courses,
            'categories' => $categories,
            'stats'      => [
                'total'        => $courses->count(),
                'totalHours'   => $courses->sum('hours'),
                'totalModules' => $courses->sum('modules_count'),
            ],
        ]);
    }

    public function show(string $slug)
    {
        $course = Course::with(['modules.lessons', 'categories'])
            ->withCount('modules')
            ->where('slug', $slug)
            ->first();

        return Inertia::render('Courses/Show', [
            'course' => $course,
        ]);
    }
}
