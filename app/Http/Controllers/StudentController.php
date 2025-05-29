<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        // Fetch search and filter inputs
        $query = $request->input('query', '');
        $gender = $request->input('gender', '');

        // Fetch students based on search and filter
        $students = Student::when($query, function ($q) use ($query) {
            $q->where('full_name', 'like', '%' . $query . '%');
        })
        ->when($gender, function ($q) use ($gender) {
            $q->where('gender', $gender);
        })
        ->paginate(10);

        // Get user student accounts not yet assigned as students
        $userStudents = \App\Models\User::where('user_role', 'Student')
            ->whereNotIn('email', Student::pluck('email'))
            ->get();

        return view('students.index', compact('students', 'userStudents'));
    }

    public function create()
    {
        return view('students.create');
    }

    public function store(Request $request)
    {
        // Validate the input
        $validatedData = $request->validate([
            'full_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:Male,Female',
            '_section' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15',
            'email' => 'required|email|unique:students,email',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle file upload
        if ($request->hasFile('picture')) {
            $filePath = $request->file('picture')->store('students', 'public');
            $validatedData['picture'] = $filePath;
        }

        // Save the student to the database
        Student::create($validatedData);

        // Redirect with success message
        return redirect()->route('students.index')->with('success', 'Student added successfully!');
    }

    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|string',
            '_section' => 'required|string|max:10',
            'phone_number' => 'required|string|max:15',
            'email' => 'required|email|unique:students,email,' . $student->student_id . ',student_id',
            'picture' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('picture')) {
            $filePath = $request->file('picture')->store('students', 'public');
            $validated['picture'] = $filePath;
        }

        $student->update($validated);

        return redirect()->route('students.index')->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student)
    {
        if ($student->picture) {
            Storage::disk('public')->delete($student->picture);
        }

        $student->delete();

        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    }

    public function enrollments()
    {
        // Use the same logic as DashboardController for consistency
        $userEmail = session('email');
        $student = \App\Models\Student::where('email', $userEmail)->first();

        $enrollments = $student ? $student->enrollments()->with('course')->get() : collect();
        $courses = \App\Models\Course::all();
        return view('students.enrollments', compact('enrollments', 'courses', 'student'));
    }

    public function marks()
    {
        // Get the student by session email (consistent with enrollments)
        $userEmail = session('email');
        $student = \App\Models\Student::where('email', $userEmail)->first();

        // Get all marks for this student's enrollments
        $marks = collect();
        if ($student) {
            $marks = \App\Models\Mark::whereHas('enrollment', function($q) use ($student) {
                $q->where('student_id', $student->student_id);
            })->with(['enrollment.course'])->get();
        }

        return view('students.marks', compact('marks', 'student'));
    }
}
