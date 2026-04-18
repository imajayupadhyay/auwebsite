<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class CoursesController extends Controller
{
    private array $levels = ['Beginner', 'Intermediate', 'Advanced', 'All levels'];

    public function index(Request $request)
    {
        $search     = $request->input('search', '');
        $categoryId = $request->input('category', '');

        $courses = Course::with('categories')
            ->when($search, fn ($q) =>
                $q->where(fn ($q2) =>
                    $q2->where('title', 'like', "%{$search}%")
                       ->orWhere('code', 'like', "%{$search}%")
                )
            )
            ->when($categoryId, fn ($q) =>
                $q->whereHas('categories', fn ($c) => $c->where('categories.id', $categoryId))
            )
            ->orderBy('sort_order')
            ->orderBy('id')
            ->paginate(15)
            ->withQueryString();

        return Inertia::render('Admin/Courses/Index', [
            'courses'    => $courses,
            'categories' => Category::orderBy('name')->get(['id', 'name', 'parent_id']),
            'filters'    => ['search' => $search, 'category' => $categoryId],
            'stats'      => [
                'total'     => Course::count(),
                'available' => Course::available()->count(),
                'drafts'    => Course::where('available', false)->count(),
            ],
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Courses/Create', [
            'categories' => Category::orderBy('name')->get(['id', 'name', 'parent_id']),
            'levels'     => $this->levels,
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateCourse($request);
        $categories = $request->validate(['categories' => 'required|array|min:1'])['categories'];

        $data['slug'] = $data['slug'] ?: Str::slug($data['title']);

        $course = Course::create($data);
        $course->categories()->sync($categories);

        return redirect()->route('admin.courses.edit', $course)->with('success', 'Course created.');
    }

    public function edit(Course $course)
    {
        $course->load(['categories', 'modules.lessons']);

        return Inertia::render('Admin/Courses/Edit', [
            'course'        => $course,
            'allCategories' => Category::orderBy('name')->get(['id', 'name', 'parent_id']),
            'levels'        => $this->levels,
        ]);
    }

    public function update(Request $request, Course $course)
    {
        $data = $this->validateCourse($request, $course->id);
        $categories = $request->validate(['categories' => 'required|array|min:1'])['categories'];

        $data['slug'] = $data['slug'] ?: Str::slug($data['title']);

        $course->update($data);
        $course->categories()->sync($categories);

        return back()->with('success', 'Course updated.');
    }

    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()->route('admin.courses.index')->with('success', 'Course deleted.');
    }

    private function validateCourse(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'code'             => "required|string|max:20|unique:courses,code,{$ignoreId}",
            'slug'             => "nullable|string|max:160|unique:courses,slug,{$ignoreId}",
            'title'            => 'required|string|max:200',
            'subtitle'         => 'nullable|string|max:255',
            'icon'             => 'nullable|string|max:120',
            'dot_color'        => 'nullable|string|max:9',
            'level'            => 'required|string|max:32',
            'language'         => 'required|string|max:40',
            'hours'            => 'integer|min:0',
            'price'            => 'integer|min:0',
            'original_price'   => 'nullable|integer|min:0',
            'rating'           => 'nullable|numeric|min:0|max:5',
            'students'         => 'integer|min:0',
            'available'        => 'boolean',
            'last_updated_text'=> 'nullable|string|max:40',
            'description'      => 'nullable|string',
            'tags'             => 'nullable|array',
            'tags.*'           => 'string|max:60',
            'outcomes'         => 'nullable|array',
            'outcomes.*'       => 'string|max:300',
            'requirements'     => 'nullable|array',
            'requirements.*'   => 'string|max:300',
            'sort_order'       => 'integer|min:0',
        ]);
    }
}
