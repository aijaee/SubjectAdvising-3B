<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Ensure the enrollments() relationship exists in the Course model
        $query = Course::withCount('enrollments');
        if ($request->filled('query')) {
            $query->where('course_name', 'like', '%' . $request->input('query') . '%');
        }
        if ($request->filled('year_level')) {
            $query->where('year_level', $request->input('year_level'));
        }
        $courses = $query->paginate(10);

        return view('courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('courses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        return view('courses.edit', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     */
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('courses.index');
    }
}
