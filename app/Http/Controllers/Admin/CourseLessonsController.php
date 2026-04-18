<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CourseLesson;
use App\Models\CourseModule;
use App\Support\GoogleDrive;
use Illuminate\Http\Request;

class CourseLessonsController extends Controller
{
    public function store(Request $request, CourseModule $module)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:200',
            'duration'    => 'nullable|string|max:20',
            'drive_input' => 'nullable|string|max:500',
            'is_preview'  => 'boolean',
            'sort_order'  => 'integer|min:0',
        ]);

        $data['module_id']     = $module->id;
        $data['drive_file_id'] = GoogleDrive::extractFileId($data['drive_input'] ?? null);
        $data['sort_order']    = $data['sort_order'] ?? ($module->lessons()->max('sort_order') + 1);
        unset($data['drive_input']);

        CourseLesson::create($data);

        return back()->with('success', 'Lesson added.');
    }

    public function update(Request $request, CourseLesson $lesson)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:200',
            'duration'    => 'nullable|string|max:20',
            'drive_input' => 'nullable|string|max:500',
            'is_preview'  => 'boolean',
            'sort_order'  => 'integer|min:0',
        ]);

        $data['drive_file_id'] = GoogleDrive::extractFileId($data['drive_input'] ?? null);
        unset($data['drive_input']);

        $lesson->update($data);

        return back()->with('success', 'Lesson updated.');
    }

    public function destroy(CourseLesson $lesson)
    {
        $lesson->delete();

        return back()->with('success', 'Lesson deleted.');
    }
}
