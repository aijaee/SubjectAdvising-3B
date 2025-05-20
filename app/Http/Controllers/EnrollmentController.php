<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Course;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $students = Student::all();
        $courses = Course::all();
        $enrollments = Enrollment::with(['student', 'course'])
            ->when($request->input('query'), function($q) use ($request) {
                $q->whereHas('student', function($q2) use ($request) {
                    $q2->where('full_name', 'like', '%' . $request->input('query') . '%');
                })->orWhereHas('course', function($q2) use ($request) {
                    $q2->where('course_name', 'like', '%' . $request->input('query') . '%');
                });
            })
            ->when($request->input('status'), function($q) use ($request) {
                $q->where('enrollment_status', $request->input('status'));
            })
            ->paginate(10);

        return view('enrollments.index', compact('enrollments', 'students', 'courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $students = Student::all();
        $courses = Course::all();
        return view('enrollments.create', compact('students', 'courses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,student_id',
            'course_id' => 'required|exists:courses,course_id',
            'enrollment_date' => 'required|date',
            'enrollment_status' => 'required|string|max:20',
        ]);
        Enrollment::create($request->all());
        return redirect()->route('enrollments.index')->with('success', 'Enrollment added!');
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
    public function edit(Enrollment $enrollment)
    {
        // If you want to keep the edit route but don't have a view, redirect with a message
        return redirect()->route('enrollments.index')->with('error', 'Edit view not implemented.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Enrollment $enrollment)
    {
        $request->validate([
            'student_id' => 'required|exists:students,student_id',
            'course_id' => 'required|exists:courses,course_id',
            'enrollment_date' => 'required|date',
            'enrollment_status' => 'required|string|max:20',
        ]);
        $enrollment->update($request->all());
        return redirect()->route('enrollments.index')->with('success', 'Enrollment updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Enrollment $enrollment)
    {
        $enrollment->delete();
        return redirect()->route('enrollments.index')->with('success', 'Enrollment deleted!');
    }

    /**
     * Get enrollment data as JSON for AJAX editing.
     */
    public function getEnrollment($id)
    {
        $enrollment = Enrollment::with(['student', 'course'])->findOrFail($id);
        return response()->json($enrollment);
    }
}
