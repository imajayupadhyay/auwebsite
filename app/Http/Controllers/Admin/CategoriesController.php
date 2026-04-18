<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class CategoriesController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search', '');

        $tree = Category::with('children.children')
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->when($search, fn ($q) => $q->where(fn ($q2) =>
                $q2->where('name', 'like', "%{$search}%")
                   ->orWhereHas('children', fn ($c) => $c->where('name', 'like', "%{$search}%"))
            ))
            ->get();

        $flat = Category::with('parent')
            ->orderBy('sort_order')
            ->get();

        return Inertia::render('Admin/Categories/Index', [
            'tree'    => $tree,
            'flat'    => $flat,
            'filters' => ['search' => $search],
            'stats'   => [
                'total'   => Category::count(),
                'parents' => Category::whereNull('parent_id')->count(),
            ],
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:120',
            'slug'        => 'nullable|string|max:140|unique:categories,slug',
            'parent_id'   => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'sort_order'  => 'integer|min:0',
        ]);

        $data['slug'] = $data['slug'] ? Str::slug($data['slug']) : Str::slug($data['name']);

        Category::create($data);

        return back()->with('success', 'Category created.');
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:120',
            'slug'        => "nullable|string|max:140|unique:categories,slug,{$category->id}",
            'parent_id'   => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'sort_order'  => 'integer|min:0',
        ]);

        $data['slug'] = $data['slug'] ? Str::slug($data['slug']) : Str::slug($data['name']);

        // Prevent a category from becoming its own ancestor
        if ($data['parent_id']) {
            $parentId = $data['parent_id'];
            while ($parentId) {
                if ($parentId == $category->id) {
                    return back()->withErrors(['parent_id' => 'A category cannot be its own ancestor.']);
                }
                $parentId = Category::find($parentId)?->parent_id;
            }
        }

        $category->update($data);

        return back()->with('success', 'Category updated.');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return back()->with('success', 'Category deleted.');
    }
}
