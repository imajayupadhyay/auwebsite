<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseModule;
use Illuminate\Http\Request;

class CourseModulesController extends Controller
{
    public function store(Request $request, Course $course)
    {
        $data = $request->validate([
            'title'      => 'required|string|max:200',
            'duration'   => 'nullable|string|max:20',
            'sort_order' => 'integer|min:0',
        ]);

        $data['course_id'] = $course->id;
        $data['sort_order'] = $data['sort_order'] ?? ($course->modules()->max('sort_order') + 1);

        CourseModule::create($data);

        return back()->with('success', 'Module added.');
    }

    public function update(Request $request, CourseModule $module)
    {
        $data = $request->validate([
            'title'      => 'required|string|max:200',
            'duration'   => 'nullable|string|max:20',
            'sort_order' => 'integer|min:0',
        ]);

        $module->update($data);

        return back()->with('success', 'Module updated.');
    }

    public function destroy(CourseModule $module)
    {
        $module->delete();

        return back()->with('success', 'Module deleted.');
    }
}
