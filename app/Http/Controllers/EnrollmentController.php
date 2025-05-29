<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Course;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function index(Request $request)
    {
        $students = Student::all();
        $courses = \App\Models\Course::withCount('enrollments')->get();
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

    public function create()
    {
        $students = Student::all();
        $courses = Course::all();
        return view('enrollments.create', compact('students', 'courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,student_id',
            'course_id' => 'required|exists:courses,course_id',
            'enrollment_date' => 'required|date',
            'enrollment_status' => 'required|string|max:20',
        ]);
        Enrollment::create($request->all());

        $userRole = session('user_role');
        if ($userRole === 'Student') {
            return redirect()->route('student.enrollments')->with('success', 'Enrollment added!');
        }
        return redirect()->route('enrollments.index')->with('success', 'Enrollment added!');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(Enrollment $enrollment)
    {
        return redirect()->route('enrollments.index')->with('error', 'Edit view not implemented.');
    }

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

    public function destroy(Enrollment $enrollment)
    {
        $enrollment->delete();
        return redirect()->route('enrollments.index')->with('success', 'Enrollment deleted!');
    }

    public function getEnrollment($id)
    {
        $enrollment = Enrollment::with(['student', 'course'])->findOrFail($id);
        return response()->json($enrollment);
    }
}
