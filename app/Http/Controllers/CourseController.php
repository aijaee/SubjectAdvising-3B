<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $query = Course::query();
        if ($request->filled('query')) {
            $query->where('course_name', 'like', '%' . $request->input('query') . '%');
        }
        if ($request->filled('year_level')) {
            $query->where('year_level', $request->input('year_level'));
        }
        if ($request->filled('duration')) {
            $query->where('duration', $request->input('duration'));
        }
        $courses = $query->paginate(10);

        foreach ($courses as $course) {
            $enrollments = \App\Models\Enrollment::where('course_id', $course->course_id)->get();
            $course->active_enrollments_count = $enrollments->filter(function($enrollment) {
                return strtolower(trim($enrollment->enrollment_status)) === 'active';
            })->count();
        }

        return view('courses.index', compact('courses'));
    }

    public function create()
    {
        return view('courses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_name' => 'required',
            'description' => 'nullable',
            'duration' => 'nullable',
            'instructor' => 'nullable',
            'year_level' => 'nullable',
            'course_fee' => 'nullable|numeric',
        ]);
        Course::create($validated);
        return redirect()->route('courses.index');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(Course $course)
    {
        return view('courses.edit', compact('course'));
    }

    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);
        $validated = $request->validate([
            'course_name' => 'required',
            'description' => 'nullable',
            'duration' => 'nullable',
            'instructor' => 'nullable',
            'year_level' => 'nullable',
            'course_fee' => 'nullable|numeric',
        ]);
        $course->update($validated);

        if ($request->expectsJson() || $request->isJson()) {
            return response()->json(['success' => true]);
        }
        return redirect()->route('courses.index')->with('success', 'Course updated!');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('courses.index');
    }
}
