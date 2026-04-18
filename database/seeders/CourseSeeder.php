<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Course;
use App\Models\CourseLesson;
use App\Models\CourseModule;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $courses = require __DIR__ . '/data/courses.php';

        foreach ($courses as $i => $data) {
            $curriculum = $data['curriculum'] ?? [];
            unset($data['curriculum'], $data['category']);

            $course = Course::updateOrCreate(
                ['code' => $data['code']],
                array_merge($data, ['sort_order' => $i])
            );

            // Sync categories by matching top-level slug
            $original = require __DIR__ . '/data/courses.php';
            $categoryName = $original[$i]['category'] ?? null;
            if ($categoryName) {
                $cat = Category::where('slug', \Illuminate\Support\Str::slug($categoryName))->first();
                if ($cat) {
                    $course->categories()->syncWithoutDetaching([$cat->id]);
                }
            }

            // Seed modules + lessons (only if not already present)
            if ($course->modules()->count() === 0) {
                foreach ($curriculum as $modOrder => $mod) {
                    $module = CourseModule::create([
                        'course_id'  => $course->id,
                        'title'      => $mod['title'],
                        'duration'   => $mod['duration'] ?? null,
                        'sort_order' => $modOrder,
                    ]);

                    foreach ($mod['lessons'] as $lessonOrder => $lessonTitle) {
                        CourseLesson::create([
                            'module_id'  => $module->id,
                            'title'      => $lessonTitle,
                            'sort_order' => $lessonOrder,
                        ]);
                    }
                }
            }
        }
    }
}
